<?php
class AluguelFilter
{
	private $dataCadastro;
	private $dataCadastroFinal;
	private $dataAtualizaoInicial;
	private $dataAtualizaoFinal;
	private $cnpjFornecedor;
	private $nomeFornecedor;
	private $categoria;
	private $valorVestuario;
	private $dataLocacaoInicial;
	private $dataLocacaoFinal;
	private $dataDevolucaoInicial;
	private $dataDevolucaoFinal;
	private $cpfCliente;
	private $nomeCliente;
	private $cpfFuncionario;
	private $nomeFuncionario;
	
	public function __construct(){}
    
    public function getDataCadastro(){
		return $this->dataCadastro;
	}
	
	public function setDataCadastro($dataCadastro){
		$this->dataCadastro = $dataCadastro;
	}
    public function getDataCadastroFinal(){
		return $this->dataCadastroFinal;
	}
	
	public function setDataCadastroFinal($dataCadastroFinal){
		$this->dataCadastroFinal = $dataCadastroFinal;
	}
    public function getDataAtualizaoInicial(){
		return $this->dataAtualizaoInicial;
	}
	
	public function setDataAtualizaoInicial($dataAtualizaoInicial){
		$this->dataAtualizaoInicial = $dataAtualizaoInicial;
	}
    public function getDataAtualizaoFinal(){
		return $this->dataAtualizaoFinal;
	}
	
	public function setDataAtualizaoFinal($dataAtualizaoFinal){
		$this->dataAtualizaoFinal = $dataAtualizaoFinal;
	}
    public function getCnpjFornecedor(){
		return $this->cnpjFornecedor;
	}
	
	public function setCnpjFornecedor($cnpjFornecedor){
		$this->cnpjFornecedor = $cnpjFornecedor;
	}
    public function getNomeFornecedor(){
		return $this->nomeFornecedor;
	}
	
	public function setNomeFornecedor($nomeFornecedor){
		$this->nomeFornecedor = $nomeFornecedor;
	}
    public function getCategoria(){
		return $this->categoria;
	}
	
	public function setCategoria($categoria){
		$this->categoria = $categoria;
	}
    public function getValorVestuario(){
		return $this->valorVestuario;
	}
	
	public function setValorVestuario($valorVestuario){
		$this->valorVestuario = $valorVestuario;
	}
	public function getDataLocacaoInicial(){
		return $this->dataLocacaoInicial;
	}
	
	public function setDataLocacaoInicial($dataLocacaoInicial){
		$this->dataLocacaoInicial = $dataLocacaoInicial;
	}
	
    public function getDataLocacaoFinal(){
		return $this->dataLocacaoFinal;
	}
	
	public function setDataLocacaoFinal($dataLocacaoFinal){
		$this->dataLocacaoFinal = $dataLocacaoFinal;
	}
	
	public function getDataDevolucaoInicial(){
		return $this->dataDevolucaoInicial;
	}
	
	public function setDataDevolucaoInicial($dataDevolucaoInicial)
	{
		$this->dataDevolucaoInicial = $dataDevolucaoInicial;
	}

	public function getDataDevolucaoFinal()
	{
		return $this->dataDevolucaoFinal;
	}
	
	public function setDataDevolucaoFinal($dataDevolucaoFinal)
	{
		$this->dataDevolucaoFinal = $dataDevolucaoFinal;
	}
	
	public function getCpfCliente()
	{
		return $this->cpfCliente;
	}
	
	public function setCpfCliente($cpfCliente)
	{
		$this->cpfCliente = $cpfCliente;
	}
	
	public function getNomeCliente()
	{
		return $this->nomeCliente;
	}
	
	public function setNomeCliente($nomeCliente)
	{
		$this->nomeCliente = $nomeCliente;
	}
	
	public function getCpfFuncionario()
	{
		return $this->cpfFuncionario;
	}
	
	public function setCpfFuncionario($cpfFuncionario) 
	{
		$this->cpfFuncionario = $cpfFuncionario;
	}
	
	public function getNomeFuncionario()
	{
		return $this->nomeFuncionario;
	}
	
	public function setNomeFuncionario($nomeFuncionario) 
	{
		$this->nomeFuncionario = $nomeFuncionario;
	}
	
}
?>