package persistencia;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.util.ArrayList;
import java.sql.ResultSet;
import model.Pessoa;

public class PessoaDAO {
    private Connection bd;

    public PessoaDAO() {
        this.bd = BancoDeDados.getBd();
    }

    // CREATE
    public void cadastrar(Pessoa p) throws SQLException {
        String query = """
                INSERT INTO pessoa
                VALUES (null, ?, ?, ?)
        """;

        try (PreparedStatement st = this.bd.prepareStatement(query)) {
            st.setNString(1, p.getNome());
            st.setString(2, p.getCpf());
            st.setString(3, p.getData());
            st.executeUpdate();
        } catch (SQLException e) {
            e.printStackTrace();
            System.out.println("Erro ao cadastrar pessoa.");
        }
    }

    // DELETE - Apaga todos os registros com base no CPF
    public void deletar(Pessoa p) throws SQLException {
        String query = """
                DELETE FROM pessoa
                WHERE cpf = ?
        """;

        try (PreparedStatement st = bd.prepareStatement(query)) {
            st.setString(1, p.getCpf());
            st.executeUpdate();
        } catch (SQLException e) {
            e.printStackTrace();
            System.out.println("Erro ao deletar pessoa.");
        }
    }

    // UPDATE
    public void atualizarNome(Pessoa p) throws SQLException {
        String query = """
                UPDATE pessoa
                SET nome = ?
                WHERE cpf = ?
        """;

        try (PreparedStatement st = this.bd.prepareStatement(query)) {
            st.setString(1, p.getNome());
            st.setString(2, p.getCpf());
            st.executeUpdate();
        } catch (SQLException e) {
            e.printStackTrace();
            System.out.println("Erro ao atualizar nome da pessoa.");
        }
    }

    // READ - Retorna todas as pessoas no banco de dados
    public ArrayList<Pessoa> getAllPess() throws SQLException {
        ArrayList<Pessoa> lista = new ArrayList<>();
        String query = "SELECT nome, cpf, data_nasc FROM pessoa";

        try (PreparedStatement st = this.bd.prepareStatement(query);
             ResultSet res = st.executeQuery()) {
            while (res.next()) {
                String nome = res.getString("nome");
                String cpf = res.getString("cpf");
                String dataNasc = res.getString("data_nasc");
                lista.add(new Pessoa(nome, cpf, dataNasc));
            }
        } catch (SQLException e) {
            e.printStackTrace();
            System.out.println("Erro ao listar pessoas.");
        }
        return lista;
    }

    public String getNomebyCpf(String umCpf) throws SQLException {
        String query = """
                SELECT nome 
                FROM pessoa
                WHERE cpf = ?
        """;

        try (PreparedStatement st = bd.prepareStatement(query)) {
            st.setString(1, umCpf);
            try (ResultSet res = st.executeQuery()) {
            	
                if (res.next()) {
                	String nome = res.getString("nome");
                    return nome;
                } else {
                    System.out.println("Nenhum nome encontrado");
                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
            System.out.println("Erro ao buscar nome por CPF.");
        }
        return null;
    }

    
    
    // Busca pessoa pelo CPF
    public Pessoa findbyCpf(String umCpf) throws SQLException {
        String query = """
                SELECT nome, cpf, data_nasc 
                FROM pessoa
                WHERE cpf = ?
        """;

        try (PreparedStatement st = bd.prepareStatement(query)) {
            st.setString(1, umCpf);
            try (ResultSet res = st.executeQuery()) {
                if (res.next()) {
                    return new Pessoa(res.getString("nome"), res.getString("cpf"), res.getString("data_nasc"));
                } else {
                    System.out.println("Nenhum registro encontrado");
                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
            System.out.println("Erro ao buscar pessoa por CPF.");
        }
        return null;
    }

    // Busca ID pelo CPF
    public int getIdbyCpf(String umCpf) throws SQLException {
        String query = """
                SELECT cod_pessoa
                FROM pessoa
                WHERE cpf = ?
        """;

        try (PreparedStatement st = bd.prepareStatement(query)) {
            st.setString(1, umCpf);
            try (ResultSet res = st.executeQuery()) {
                if (res.next()) {
                    return res.getInt("cod_pessoa");
                } else {
                    System.out.println("Nenhum registro encontrado");
                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
            System.out.println("Erro ao obter ID por CPF.");
        }
        return 0;
    }
    
    
}
