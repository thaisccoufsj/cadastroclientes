<?php

namespace App\Http\Controllers;

use App\Apis\CustomerApi\CustomerClient;
use App\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use stdClass;

class CustomerController extends Controller
{
    /**
     * Client da Api
     *
     * @var CustomerClient
     */
    private $client;

    /**
     * Construtor
     */
    public function __construct()
    {
        $this->client = new CustomerClient();
    }

    /**
     * Exibe formulário de criação de cliente
     */
    public function create()
    {
        return view('pages.customer-create');
    }

    /**
     * Exibe formulário de edição de um cliente
     *
     * @param int $id
     * @return mixed
     */
    public function edit(int $id)
    {
        $response = $this->client->getCustomers(['id' => $id]);

        if ($response->failed()) {
            return redirect()->route('list-customer')->with('error', 'Houve um erro ao consultar o cliente solicitado');
        }

        $data = (array) $response->getData();
        $customerData = current($data);

        if (!$customerData) {
            return redirect()->route('list-customer')->with('error', 'Cliente não encontrado para edição');
        }

        $customer = (object) current($customerData);

        return view('pages.customer-edit', ['customer' => $customer]);
    }

    /**
     * Edita um cliente
     *
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {
        $customer = $this->buildCustomerObject($request);
        $customerData = $request->all();
        unset($customerData['_token']);
        if ($request->birthDate) {
            $customerData['birthDate'] = Carbon::createFromFormat('d/m/Y', $request->birthDate)->format('Y-m-d');
        }

        $response = null;

        $response = array_key_exists('id', $customerData) ?
            $this->client->editCustomer($customerData) :
            $this->client->insertCustomer($customerData);

        if ($response->failed()) {
            $message = 'Houve um erro ao salvar o cliente.';

            //Erro de validação
            if ($response->getCode() == 400) {
                $message = $response->getMessage();
                $message = json_decode($response->getMessage(), true)['message'];
                return back()->with('errors', $message)->with('customer', $customer);
            }

            return back()->with('error', $message)->with('customer', $customer);
        }

        return redirect()->route('list-customer')->with('sucess', 'Cliente salvo com sucesso');
    }

    /**
     * Lista os clientes
     *
     * @param Request $request
     * @return mixed
     */
    public function list(Request $request)
    {
        $response = $this->client->getCustomers($request->all());
        $responseData = (array) $response->getData();
        $customers = array_key_exists('customers', $responseData) ? (array) $responseData['customers'] : [];
        $total = array_key_exists('total', $responseData) ? (string) $responseData['total'] : '';
        $perPage = array_key_exists('perPage', $responseData) ? (string) $responseData['perPage'] : '';
        $currentPage = array_key_exists('currentPage', $responseData) ? (string) $responseData['currentPage'] : '';
        $paginator = new LengthAwarePaginator($customers, $total, $perPage, $currentPage);

        return view('pages.customer-list', [
            'customer' => $this->buildCustomerObject($request),
            'customers' => $customers,
            'paginator' => $paginator
        ]);
    }

    /**
     * Exclui um cliente
     *
     * @param int $id
     * @return mixed
     */
    public function delete($id)
    {
        $response = $this->client->deleteCustomer($id);

        if ($response->failed()) {
            return redirect()->route('list-customer')->with('error', 'Não foi possível excluir o cliente');
        }

        return redirect()->route('list-customer')->with('sucess', 'Cliente excluído com sucesso');
    }

    /**
     * Monta o objeto de cliente a partir dos dados da request
     *
     * @param Request $request
     * @return object
     */
    private function buildCustomerObject(Request $request): object
    {
        $customer = new stdClass;
        $customer->name = $request->name;
        $customer->cpf = $request->cpf;
        $customer->birthDate = $request->birthdate ?
            Carbon::createFromFormat('d/m/Y', $request->birthdate)->format('Y-m-d') :
            null;
        $customer->gender = $request->gender;
        $customer->address = $request->address;
        $customer->state = $request->state;
        $customer->city = $request->city;
        return $customer;
    }
}
