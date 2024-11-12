package model;
public class Pessoa {
	
	protected String nome;
	protected String cpf;
	protected String data_nasc;
	
	public Pessoa(String umNome, String umCpf, String data) {
		this.nome=umNome;
		this.cpf=umCpf;
		this.data_nasc = data;
	}
	
	//CONSTRUTOR VAZIO PROPOSITALMENTE
	public Pessoa() {
		
	}
	
	public String getNome() {
		return this.nome;
	}
	
	public void setNome(String umNome) {
		this.nome=umNome;
	}
	
	public String getCpf() {
		return this.cpf;
	}
	public void setCpf(String umCpf) {
		this.cpf=umCpf;
	}
	
	public String getData() {
		return this.data_nasc;
	}
	
	public void setData(String data) {
		this.data_nasc=data;
	}
	
	 @Override
	public String toString() {
		return "Nome: "+this.nome+" CPF:"+this.cpf+" Data de Nascimento: "+ this.data_nasc;
	}
}