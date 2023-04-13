<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Rules\CpfValidation;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Validator;

class CustomerController extends Controller
{
    /**
     * noem dos campos para exibição
     */
    const EXHIBITION_FIELD_NAMES = [
        'name' => 'nome',
        'cpf' => 'cpf',
        'birthdate' => 'data de nascimento',
        'gender' => 'sexo',
        'address' => 'endereço',
        'state' => 'estado',
        'city' => 'cidade'
    ];

    /**
     * Exibe formulário de criação de cliente
     */
    public function create()
    {
        return view('pages.customer-create');
    }

    /**
     * Exibe formulário de edição de cliente
     */
    public function edit($id)
    {
        $customer = Customer::where('id', $id)->first();

        if (!$customer) {
            return redirect()->route('list-customer')->with('error', 'Cliente não encontrado para edição');
        }

        return view('pages.customer-edit', ['customer' => $customer]);
    }

    /**
     * Lista os clientes
     */
    public function list()
    {
        $customers = Customer::paginate($this->pageSize);
        return view('pages.customer-list', ['customers' => $customers]);
    }

    /**
     * Busca e lista os clientes
     * 
     * @param Request $request
     */
    public function search(Request $request)
    {
        $customer = $this->buildCustomerObject($request);
        $customers = $this->requestHasNotemptyFields($request) ?
            $this->filter($request) :
            Customer::paginate($this->pageSize);

        return view('pages.customer-list', ['customer' => $customer, 'customers' => $customers]);
    }

    public function filter(Request $request)
    {
        $queryBuilder = Customer::query();

        foreach ($request->all() as $field => $value) {
            if (in_array($field, ['_token', 'gender', 'page']) || empty($value)) {
                continue;
            }

            if (str_contains($field, 'date')) {
                $value = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
            }

            $queryBuilder->where($field, 'like', "%$value%");
        }

        if ($request->gender) {
            $queryBuilder->where('gender', $request->gender);
        }

        return $queryBuilder->paginate($this->pageSize);
    }

    /**
     * Monsta o objeto de cliente a partir dos dados da request
     *
     * @param Request $request
     * @return Customer
     */
    private function buildCustomerObject(Request $request): Customer
    {
        $customer = new Customer();
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

    /**
     * Insere um novo cliente
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->getValidationRules(), [], self::EXHIBITION_FIELD_NAMES);

        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }

        $customer = $this->buildCustomerObject($request);

        try {
            $customer->save();
        } catch (Exception $e) {
            return back()->with('error', 'Não foi possível salvar o cliente');
        }

        return redirect()->route('list-customer')->with('sucess', 'Cliente criado com sucesso');
    }

    /**
     * Edita um novo cliente
     *
     * @param Request $request
     */
    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), $this->getValidationRules(), [], self::EXHIBITION_FIELD_NAMES);

        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }

        $customer = $this->buildCustomerObject($request);

        try {
            $customer->save();
        } catch (Exception $e) {
            return back()->with('error', 'Não foi possível salvar o cliente');
        }

        return redirect()->route('list-customer')->with('sucess', 'Cliente editado com sucesso');
    }

    /**
     * Exclui um cliente
     *
     * @param int $id
     */
    public function delete($id)
    {
        try {
            Customer::where('id', $id)->delete();
        } catch (Exception $e) {
            return back()->with('error', 'Não foi possível excluir o cliente');
        }

        return redirect()->route('list-customer')->with('sucess', 'Cliente excluído com sucesso');
    }

    /**
     * Obtém as regras de validação do formulário
     *
     * @return array
     */
    public function getValidationRules(): array
    {
        return [
            'name' => ['required', 'min:3'],
            'cpf' => ['required', 'min:14','max:14', new CpfValidation],
            'birthdate' => ['required', 'min:10', 'max:10'],
            'gender' => ['required'],
            'address' => ['required'],
            'state' => ['required'],
            'city' => ['required']
        ];
    }
}
