package model;

import java.time.LocalDate;
import java.time.Period;

public class Passageiro extends Pessoa {
    protected String tipo;
    protected int idade;

    public Passageiro(String umNome, String umCpf, String data) {
        super(umNome, umCpf, data);
    }

    public Passageiro() {}

    public String getTipo() {
        return this.tipo;
    }

    public void setTipo(String modalidade) {
        this.tipo = modalidade;
    }

    
    public String modalidade(int r) {
        try {
            LocalDate dataNascimento = LocalDate.parse(getData()); 
            LocalDate dataAtual = LocalDate.now();
            Period periodo = Period.between(dataNascimento, dataAtual);
            this.idade = periodo.getYears();

            switch (r) {
                case 1:
                    if (this.idade >= 60) {
                        this.tipo = "PASSE LIVRE +60";
                    } else {
                        System.out.println("VOCÊ NÃO POSSUI IDADE SUFICIENTE");
                    }
                    break;
                case 2:
                    if (this.idade >= 65) {
                        this.tipo = "PASSE LIVRE +65";
                    } else {
                        System.out.println("VOCÊ NÃO POSSUI IDADE SUFICIENTE");
                    }
                    break;
                case 3:
                    this.tipo = "PCD";
                    break;
                case 4:
                    this.tipo = "ESTUDANTE";
                    break;
                case 5:
                    this.tipo = "PASSE ANTECIPADO";
                    break;
                default:
                    System.out.println("Modalidade inválida.");
            }
        } catch (Exception e) {
            e.printStackTrace();
            System.out.println("Erro ao calcular modalidade.");
        }
        return this.tipo;
    }

    @Override
    public String toString() {
        return super.toString() + " Modalidade: " + this.tipo;
    }
}
