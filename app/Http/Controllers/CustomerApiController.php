<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Rules\CpfValidation;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Validator;

class CustomerApiController extends Controller
{
    /**
     * Nome dos campos para exibição
     */
    const EXHIBITION_FIELD_NAMES = [
        'name' => 'nome',
        'cpf' => 'cpf',
        'birthDate' => 'data de nascimento',
        'gender' => 'sexo',
        'address' => 'endereço',
        'state' => 'estado',
        'city' => 'cidade'
    ];

     /**
     * Insere um novo cliente
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), $this->getValidationRules(), [], self::EXHIBITION_FIELD_NAMES);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors()
            ], 400);
        }

        $customer = new Customer();
        $customer->name = $request->name;
        $customer->cpf = $request->cpf;
        $customer->birthDate = $request->birthDate;
        $customer->gender = $request->gender;
        $customer->address = $request->address;
        $customer->city = $request->city;
        $customer->state = $request->state;

        try {
            $customer->save();
        } catch (Exception $e) {
            return response()->json([
                "message" => 'Não foi possível salvar o cliente'
            ], 422);
        }

        return response()->json([
            "message" => 'Cliente criado com sucesso'
        ], 200);
    }

    /**
     * Edita um cliente
     *
     * @param Request $request
     */
    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), $this->getValidationRules(), [], self::EXHIBITION_FIELD_NAMES);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors()
            ], 400);
        }

        $customer = Customer::find($request->id);
        $customer->name = $request->name;
        $customer->cpf = $request->cpf;
        $customer->birthDate = $request->birthDate;
        $customer->gender = $request->gender;
        $customer->address = $request->address;
        $customer->city = $request->city;
        $customer->state = $request->state;

        if (!$customer) {
            return response()->json([
                "message" => 'Cliente não encontrado'
            ], 422);
        }

        try {
            $customer->update();
        } catch (Exception $e) {
            return response()->json([
                "message" => 'Não foi possível salvar o cliente '
            ], 422);
        }

        return response()->json([
            "message" => 'Cliente editado com sucesso'
        ], 200);
    }

    /**
     * Exclui um cliente
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id): \Illuminate\Http\JsonResponse
    {
        try {
            Customer::where('id', $id)->delete();
        } catch (Exception $e) {
            return response()->json([
                "message" => "Não foi possível excluir o cliente" . $e->getMessage()
            ], 422);
        }

        return response()->json([
            "message" => "Cliente excluído com sucesso"
        ], 200);
    }

    /**
     * Lista os clientes
     *
     * @param Request $request
     * @return mixed
     */
    public function list(Request $request)
    {
        $queryBuilder = $this->filter($request);

        try {
            $customersPaginated = $queryBuilder->paginate($this->pageSize);
            $customers = $queryBuilder->get();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Não foi possível consultar os clientes'
            ], 422);
        }

        return response()->json([
            'customers' => $customers,
            'pagination' => $customersPaginated->appends($request->except('page'))->render(),
            'total' => $customersPaginated->total(),
            'perPage' => $customersPaginated->perPage(),
            'currentPage' => $customersPaginated->currentPage()
        ]);
    }

    /**
     * Aplica os filtros da requisição
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function filter(Request $request): \Illuminate\Database\Eloquent\Builder
    {
        $queryBuilder = Customer::query();

        foreach ($request->all() as $field => $value) {
            if (in_array($field, ['_token', 'gender', 'page']) || empty($value)) {
                continue;
            }

            if (str_contains($field, 'date')) {
                $value = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
            }
            $queryBuilder->where($field, 'like', "%{$value}%");
        }

        if ($request->gender) {
            $queryBuilder->where('gender', $request->gender);
        }

        return $queryBuilder;
    }

    /**
     * Obtém as regras de validação do formulário
     *
     * @return array
     */
    private function getValidationRules(): array
    {
        return [
            'name' => ['required', 'min:3'],
            'cpf' => ['required', 'min:14','max:14', new CpfValidation],
            'birthDate' => ['required', 'min:10', 'max:10'],
            'gender' => ['required'],
            'address' => ['required'],
            'state' => ['required'],
            'city' => ['required']
        ];
    }
}
