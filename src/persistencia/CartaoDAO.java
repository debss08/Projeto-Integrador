package persistencia;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import model.Cartao;
import model.Passageiro;
import model.Pessoa;


public class CartaoDAO {
	
	private Connection bd;	
	
	public CartaoDAO() {
		this.bd = BancoDeDados.getBd();
	}
	
	
	public void criarCartao(Cartao c,PassageiroDAO ps, String cpf) throws SQLException { //  cadastrar usuário 
		String query = """
				INSERT INTO cartao
				VALUES (null, ?, ?, ?)
		""";
		
		PreparedStatement st = this.bd.prepareStatement(query);
		st.setInt(1, ps.getIdbyPessoa(cpf));
		st.setDouble(2, c.calcularTarifa(ps.getModalidade(cpf)));
		st.setDouble(3, c.getSaldo());
		st.executeUpdate();
	}
	

	
	public void recarregarCartao(double saldo, PassageiroDAO ps, String cpf) throws SQLException{
		String query = """
				UPDATE cartao
				SET saldo = saldo +  ?
				WHERE cod_pass = ?   
		""";
		PreparedStatement st = bd.prepareStatement(query);
		st.setDouble(1, saldo);
		st.setInt(2, ps.getIdbyPessoa(cpf));
		st.executeUpdate();
	}
	
	public double getSaldobyCpf(PassageiroDAO ps, String umCpf) throws SQLException{ //localiza e retorna o id da pessoa
		String query = """
				SELECT saldo
				FROM cartao
				WHERE cod_pass = ?
				""";
		PreparedStatement st = bd.prepareStatement(query);
		st.setInt(1, ps.getIdbyPessoa(umCpf));
		ResultSet res = st.executeQuery();
		
		boolean nenhum = true;
		while (res.next()) {
			nenhum = false;
			double saldo = res.getDouble("saldo");
			return saldo;
			
		}
		if (nenhum) {
			System.out.println("Nenhum registro encontrado");
		}
		return 0;
		
		
	}
}