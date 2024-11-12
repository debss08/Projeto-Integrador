package apresentacao;
import java.sql.SQLException;
import java.sql.SQLIntegrityConstraintViolationException;
import java.util.ArrayList;
import java.util.Scanner;
import model.Pessoa;
import model.Cartao;
import model.Passageiro;
import persistencia.CartaoDAO;
import persistencia.PassageiroDAO;
import persistencia.PessoaDAO;

public class Main {
    public static void main(String[] args) {
        try {
            Scanner teclado = new Scanner(System.in);
            System.out.println("Bem-Vindo a Coleo!");
            
            while (true) {
                System.out.println("\n1-Cadastrar | 2- Listar | 3-Atualizar | 4-Exluir | 5- Recarregar cartão | 6- Checar saldo | 7-Encerrar sessão");
                int op = teclado.nextInt();
                teclado.nextLine();
                
                if (op == 1) {
                    try {
                        System.out.println("Ao realizar seu cadastro, você já possuirá seu próprio cartao da coleo! \nIsso permitirá a realização de recarga e a consulta do saldo remotamente");
                        System.out.println("\nInforme o nome:");
                        String nome = teclado.nextLine();
                        System.out.println("Informe o cpf");
                        String cpf = teclado.nextLine();
                        System.out.println("Informe a data de nascimento: ");
                        String data_nasc = teclado.nextLine();
                        
                        Passageiro ps = new Passageiro(nome, cpf, data_nasc);
                        Pessoa p = new Pessoa(nome, cpf, data_nasc);
                        
                        PassageiroDAO psd = new PassageiroDAO();  
                        PessoaDAO pd = new PessoaDAO();
                        
                        pd.cadastrar(p);
                        
                        System.out.println("Escolha uma dessas modalidades? (Informe o número correspondente)");
                        System.out.println("1-PASSE LIVRE +60");
                        System.out.println("2-PASSE LIVRE +65");
                        System.out.println("3-PCD");
                        System.out.println("4-ESTUDANTE");
                        System.out.println("5-PASSE ANTECIPADO");
                        int op2 = teclado.nextInt();
                        
                        System.out.println(ps.modalidade(op2));
                        
                        psd.beneficio(ps);
                        
                        Cartao c = new Cartao(ps);
                        CartaoDAO cdao = new CartaoDAO();
                        cdao.criarCartao(c, psd, cpf);
                        
                    } catch (SQLIntegrityConstraintViolationException e) {
                        System.out.println("\n*** Esse CPF já foi cadastrado!");
                    }
                    System.out.println("\nUsuário cadastrado com sucesso!");
                } else if (op == 2) {
                    System.out.println("1 | Listar pessoas cadastradas  2 | Listar passageiros  3 | Listar passageiros e seus cartões");
                    int r = teclado.nextInt();
                    
                    if (r == 1) {
                        PessoaDAO pd = new PessoaDAO();
                        ArrayList<Pessoa> lista = pd.getAllPess();
                        if (lista.size() == 0) {
                            System.out.println("\nO cadastro está vazio.");
                        } else {
                            System.out.println("\nPessoas cadastradas:");
                            for (Pessoa p : lista) {
                                System.out.println(p);
                            }
                        }
                    } else if (r == 2) {
                        PassageiroDAO psdao = new PassageiroDAO();
                        ArrayList<Passageiro> lista = psdao.getAllPass();
                        if (lista.size() == 0) {
                            System.out.println("\nO cadastro está vazio.");
                        } else {
                            System.out.println("\nPassageiros cadastrados:");
                            for (Passageiro p : lista) {
                                System.out.println(p);
                            }
                        }
                    } else if (r == 3) {
                        CartaoDAO cdao = new CartaoDAO();
                        PassageiroDAO psdao = new PassageiroDAO();
                        ArrayList<Cartao> lista = cdao.getAllCartoes(psdao);
                        if (lista.size() == 0) {
                            System.out.println("\nO cadastro está vazio.");
                        } else {
                            System.out.println("\nPassageiros e seus cartões:");
                            for (Cartao c : lista) {
                                System.out.println(c);
                            }
                        }
                    }
                } else if (op == 3) {
                    System.out.println("O que você deseja atualizar?");
                    System.out.println("1-Nome cadastrado || 2-Modalidade ");
                    int opcao = teclado.nextInt();
                    teclado.nextLine();
                    
                    if (opcao == 1) {
                        System.out.println("Informe o cpf do cadastro que você deseja atualizar o nome: ");
                        String cpf = teclado.nextLine();
                        
                        System.out.println("Informe o novo nome: ");
                        String nome = teclado.nextLine();
                        
                        Pessoa p = new Pessoa();
                        PessoaDAO pdao = new PessoaDAO();
                        
                        p.setNome(nome);
                        p.setCpf(cpf);
                        
                        pdao.atualizarNome(p);
                    } else if (opcao == 2) {
                        System.out.println("Informe o cpf do cadastro que você deseja atualizar a modalidade: ");
                        String cpf = teclado.nextLine();
                        
                        System.out.println("Informe a sua data de nascimento: ");
                        String data = teclado.nextLine();
                        
                        System.out.println("Escolha uma dessas modalidades? (Informe o número correspondente)");
                        System.out.println("1-PASSE LIVRE +60");
                        System.out.println("2-PASSE LIVRE +65");
                        System.out.println("3-PCD");
                        System.out.println("4-ESTUDANTE");
                        System.out.println("5-PASSE ANTECIPADO");
                        int r = teclado.nextInt();
                        
                        Passageiro ps = new Passageiro();
                        PassageiroDAO psd = new PassageiroDAO();
                        
                        ps.setData(data);
                        ps.modalidade(r);
                        psd.atualizarModalidade(ps, cpf);
                    } else {
                        System.out.println("Esta opção não está disponível!");
                    }
                } else if (op == 4) {
                    System.out.println("1-Apagar cadastro completo | 2-Apagar apenas o cartão");
                    int opcao = teclado.nextInt();
                    teclado.nextLine();
                    
                    if (opcao == 1) {
                        System.out.println("Informe o cpf");
                        String cpf = teclado.nextLine();
                        
                        PessoaDAO pd = new PessoaDAO();
                        Pessoa p = new Pessoa();
                        p.setCpf(cpf);
                        pd.deletar(p);
                    } else if (opcao == 2) {
                        System.out.println("Informe o cpf");
                        String cpf = teclado.nextLine();
                        
                        CartaoDAO cd = new CartaoDAO();
                        PassageiroDAO psdao = new PassageiroDAO();
                        Passageiro p = new Passageiro();
                        Cartao c = new Cartao(p);
                        
                        cd.getIdbyPass(cpf, psdao);
                        cd.deletarCartao(c, psdao, cpf);
                    }
                } else if (op == 5) {
                    System.out.println("Qual o cpf do passageiro que você deseja recarregar o saldo?");
                    String cpf = teclado.next();
                    
                    Passageiro dono = new Passageiro();
                    Cartao c = new Cartao(dono);
                    PassageiroDAO psdao = new PassageiroDAO();
                    CartaoDAO cdao = new CartaoDAO();
                    
                    System.out.println("Quantas passagens deseja?");
                    int nump = teclado.nextInt();
                    
                    c.calcularTarifa(psdao.getModalidade(cpf));
                    c.recarregarSaldo(nump);
                    cdao.recarregarCartao(c.getSaldo(), psdao, cpf);
                    
                    System.out.println(c.getTarifa());
                    System.out.println("Saldo atual:" + cdao.getSaldobyCpf(psdao, cpf));
                    
                } else if(op==6) {
                	System.out.println("Informe o cpf do passageiro cujo deseja consular o saldo:");
                	String cpf = teclado.nextLine();
                	CartaoDAO cdao = new CartaoDAO();
                	PassageiroDAO psdao = new PassageiroDAO();
                	PessoaDAO pdao = new PessoaDAO();
                	
                	System.out.println("Saldo do passageiro(a) "+pdao.getNomebyCpf(cpf)+": R$"+cdao.getSaldobyCpf(psdao, cpf));
                	
                } else if (op == 7) {
                    break;
                }
            }
            teclado.close();
        } catch (SQLException e) {
            // erro inesperado
            e.printStackTrace();
        } finally {
            System.out.println();
        }
    }
}
