package persistencia;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import model.Passageiro;

public class PassageiroDAO {
    private Connection bd;
    private PessoaDAO pdao = new PessoaDAO();

    public PassageiroDAO() {
        this.bd = BancoDeDados.getBd();
    }

    // CREATE - Inserção de novo Passageiro
    public void beneficio(Passageiro ps) throws SQLException {
        String query = """
                INSERT INTO passageiro
                VALUES (?, ?, ?)
        """;

        try (PreparedStatement st = this.bd.prepareStatement(query)) {
            int pessoaId = pdao.getIdbyCpf(ps.getCpf());
            st.setInt(1, pessoaId);
            st.setInt(2, pessoaId);
            st.setString(3, ps.getTipo());
            st.executeUpdate();
        } catch (SQLException e) {
            e.printStackTrace();
            System.out.println("Erro ao inserir benefício de passageiro.");
        }
    }

    // READ - Retorna todos os passageiros no banco de dados
    public ArrayList<Passageiro> getAllPass() throws SQLException {
        ArrayList<Passageiro> lista = new ArrayList<>();
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
                    stModalidade.setInt(1, pdao.getIdbyCpf(newPass.getCpf()));
                    try (ResultSet resModalidade = stModalidade.executeQuery()) {
                        if (resModalidade.next()) {
                            newPass.setTipo(resModalidade.getString("modalidade"));
                        }
                    }
                }
                lista.add(newPass);
            }
        } catch (SQLException e) {
            e.printStackTrace();
            System.out.println("Erro ao listar passageiros.");
        }
        return lista;
    }

    // UPDATE - Atualiza a modalidade do Passageiro
    public void atualizarModalidade(Passageiro ps, String cpf) throws SQLException {
        String query = """
                UPDATE passageiro
                SET modalidade = ?
                WHERE cod_pass = ?
        """;

        try (PreparedStatement st = this.bd.prepareStatement(query)) {
            st.setString(1, ps.getTipo());
            st.setInt(2, pdao.getIdbyCpf(cpf));
            st.executeUpdate();
        } catch (SQLException e) {
            e.printStackTrace();
            System.out.println("Erro ao atualizar modalidade do passageiro.");
        }
    }

    // Retorna a modalidade do Passageiro com base no CPF
    public String getModalidade(String cpf) throws SQLException {
        String query = """
                SELECT modalidade
                FROM passageiro
                WHERE cod_pessoa = ?
        """;

        try (PreparedStatement st = bd.prepareStatement(query)) {
            st.setInt(1, pdao.getIdbyCpf(cpf));
            try (ResultSet res = st.executeQuery()) {
                if (res.next()) {
                    return res.getString("modalidade");
                } else {
                    System.out.println("Nenhum registro encontrado");
                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
            System.out.println("Erro ao obter modalidade.");
        }
        return "null";
    }

    // Retorna o ID do Passageiro baseado no CPF
    public int getIdbyPessoa(String cpf) throws SQLException {
        String query = """
                SELECT cod_pass
                FROM passageiro
                WHERE cod_pessoa = ?
        """;

        try (PreparedStatement st = bd.prepareStatement(query)) {
            st.setInt(1, pdao.getIdbyCpf(cpf));
            try (ResultSet res = st.executeQuery()) {
                if (res.next()) {
                    return res.getInt("cod_pass");
                } else {
                    System.out.println("Nenhum registro encontrado");
                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
            System.out.println("Erro ao obter ID do passageiro.");
        }
        return 0;
    }
}
