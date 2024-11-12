package model;
public class Pessoa {
	
	private String nome;
	private String cpf;
	private String data_nasc;
	private int id;
	
	public Pessoa(String umNome, String umCpf, String data) {
		this.nome=umNome;
		this.cpf=umCpf;
		this.data_nasc = data;
	}
	
	public Pessoa() { 
		
	}
	
	public int getId() {
		return id;
	}
	public void setId(int id) {
		this.id = id;
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
	
	
	public String toString() {
		return "Nome: "+this.nome+" CPF:"+this.cpf+" Data de Nascimento: "+ this.data_nasc;
	}
}