<?php
class Aluguel 
{
	private $id;
	private $dataLocacao;
	private $dataEntrega;
	private $dataPrevistaDevolucao;
	private $dataPrevia;
	private $dataProva;
	private $valorTotalAluguel;
	private $usuario;
	private $cliente;
	private $listaAluguelVestuarios;
	private $pagamento;
	
	public function __construct(){}

	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
    public function getDataLocacao(){
		return $this->dataLocacao;
	}
	
	public function setDataLocacao($dataLocacao){
		$this->dataLocacao = $dataLocacao;
	}
	
	public function getDataEntrega(){
		return $this->dataEntrega;
	}
	
	public function setDataEntrega($dataEntrega){
		$this->dataEntrega = $dataEntrega;
	}

	public function getDataPrevistaDevolucao(){
		return $this->dataPrevistaDevolucao;
	}
	
	public function setDataPrevistaDevolucao($dataPrevistaDevolucao){
		$this->dataPrevistaDevolucao = $dataPrevistaDevolucao;
	}
	
	public function getDataPrevia(){
		return $this->dataPrevia;
	}
	
	public function setDataPrevia($dataPrevia){
		$this->dataPrevia = $dataPrevia;
	}
	
	public function getDataProva(){
		return $this->dataProva;
	}
	
	public function setDataProva($dataProva){
		$this->dataProva = $dataProva;
	}
	
	public function getValorTotalAluguel()
	{
		return $this->valorTotalAluguel;
	}
	
	public function setValorTotalAluguel($valorTotalAluguel) 
	{
		$this->valorTotalAluguel = $valorTotalAluguel;
	}
	
	public function getCliente()
	{
		return $this->cliente;
	}
	
	public function setCliente(Cliente $cliente) 
	{
		$this->cliente = $cliente;
	}
	
	public function getUsuario()
	{
		return $this->usuario;
	}
	
	public function setUsuario(Usuario $usuario) 
	{
		$this->usuario = $usuario;
	}
	
	public function getListaAluguelVestuarios()
	{
		return $this->listaAluguelVestuarios;
	}
	
	public function setListaAluguelVestuarios(ArrayList $listaAluguelVestuarios) 
	{
		$this->listaAluguelVestuarios = $listaAluguelVestuarios;
	}
	
	public function getPagamento()
	{
		return $this->pagamento;
	}
	
	public function setPagamento(Pagamento $pagamento) 
	{
		$this->pagamento = $pagamento;
	}
}
?>