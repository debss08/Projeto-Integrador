package persistencia;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;

import model.Cartao;
import model.Passageiro;

public class CartaoDAO {

    private Connection bd;

    public CartaoDAO() {
        this.bd = BancoDeDados.getBd();
    }

    // CREATE
    public void criarCartao(Cartao c, PassageiroDAO ps, String cpf) throws SQLException{
        String query = """
                INSERT INTO cartao
                VALUES (null, ?, ?, ?)
        """;
        try (PreparedStatement st = this.bd.prepareStatement(query)) {
            st.setInt(1, ps.getIdbyPessoa(cpf));
            st.setDouble(2, c.calcularTarifa(ps.getModalidade(cpf)));
            st.setDouble(3, c.getSaldo());
            st.executeUpdate();
        } catch (SQLException e) {
            System.out.println("Erro ao criar cartão: " + e.getMessage());
        }
    }

    // READ
    public ArrayList<Cartao> getAllCartoes(PassageiroDAO psdao) throws SQLException {
        ArrayList<Cartao> lista = new ArrayList<>();

        String queryPessoa = """
                SELECT nome, cpf, data_nasc 
                FROM pessoa
        """;
        try (PreparedStatement stPessoa = this.bd.prepareStatement(queryPessoa);
             ResultSet resPessoa = stPessoa.executeQuery()) {

            while (resPessoa.next()) {
                String nome = resPessoa.getString("nome");
                String cpf = resPessoa.getString("cpf");
                String dataNasc = resPessoa.getString("data_nasc");

                Passageiro newPass = new Passageiro(nome, cpf, dataNasc);

                String queryModalidade = """
                        SELECT modalidade 
                        FROM passageiro 
                        WHERE cod_pass = ?
                        """;
                try (PreparedStatement stModalidade = this.bd.prepareStatement(queryModalidade)) {
                    stModalidade.setInt(1, psdao.getIdbyPessoa(cpf));
                    try (ResultSet resModalidade = stModalidade.executeQuery()) {
                        if (resModalidade.next()) {
                            newPass.setTipo(resModalidade.getString("modalidade"));
                        }
                    }
                }

                String queryCartao = """
                        SELECT tarifa, saldo
                        FROM cartao
                        WHERE cod_pass = ?
                        """;
                try (PreparedStatement stCartao = this.bd.prepareStatement(queryCartao)) {
                    stCartao.setInt(1, psdao.getIdbyPessoa(cpf));
                    try (ResultSet resCartao = stCartao.executeQuery()) {
                        while (resCartao.next()) {
                            double tarifa = resCartao.getDouble("tarifa");
                            double saldo = resCartao.getDouble("saldo");

                            Cartao newCartao = new Cartao(newPass);
                            newCartao.setTarifa(tarifa);
                            newCartao.setSaldo(saldo);
                            lista.add(newCartao);
                        }
                    }
                }
            }
        } catch (SQLException e) {
            System.out.println("Erro ao obter cartões: " + e.getMessage());
        }

        return lista;
    }

    // UPDATE
    public void recarregarCartao(double saldo, PassageiroDAO ps, String cpf) throws SQLException{
        String query = """
                UPDATE cartao
                SET saldo = saldo +  ?
                WHERE cod_pass = ?   
        """;
        try (PreparedStatement st = bd.prepareStatement(query)) {
            st.setDouble(1, saldo);
            st.setInt(2, ps.getIdbyPessoa(cpf));
            st.executeUpdate();
        } catch (SQLException e) {
            System.out.println("Erro ao recarregar cartão: " + e.getMessage());
        }
    }

    // DELETE - EXCLUI SOMENTE O CARTAO
    public void deletarCartao(Cartao c, PassageiroDAO psdao, String cpf) throws SQLException {
        String query = """
                DELETE FROM cartao
                WHERE cod_cartao = ?
        """;
        try (PreparedStatement st = bd.prepareStatement(query)) {
            st.setInt(1, getIdbyPass(cpf, psdao));
            st.executeUpdate();
        } catch (SQLException e) {
            System.out.println("Erro ao deletar cartão: " + e.getMessage());
        }
    }

    // Acessa a chave primária da tabela "CARTÃO" no BD e retorna
    public int getIdbyPass(String cpf, PassageiroDAO psdao) throws SQLException{
        String query = """
                SELECT cod_cartao
                FROM cartao
                WHERE cod_pass = ?
        """;
        try (PreparedStatement st = bd.prepareStatement(query)) {
            st.setInt(1, psdao.getIdbyPessoa(cpf));
            try (ResultSet res = st.executeQuery()) {
                if (res.next()) {
                    return res.getInt("cod_cartao");
                } else {
                    System.out.println("Nenhum registro encontrado");
                }
            }
        } catch (SQLException e) {
            System.out.println("Erro ao buscar ID de cartão: " + e.getMessage());
        }
        return 0;
    }

    // Acessa o saldo da tabela "CARTÃO" no BD e retorna
    public double getSaldobyCpf(PassageiroDAO ps, String umCpf) throws SQLException{
        String query = """
                SELECT saldo
                FROM cartao
                WHERE cod_pass = ?
        """;
        try (PreparedStatement st = bd.prepareStatement(query)) {
            st.setInt(1, ps.getIdbyPessoa(umCpf));
            try (ResultSet res = st.executeQuery()) {
                if (res.next()) {
                    return res.getDouble("saldo");
                } else {
                    System.out.println("Nenhum registro encontrado");
                }
            }
        } catch (SQLException e) {
            System.out.println("Erro ao buscar saldo: " + e.getMessage());
        }
        return 0;
    }
}
