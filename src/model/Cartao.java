package model;

public class Cartao {
    protected Passageiro dono;
    protected double saldo;
    protected double tarifa;

    public Cartao(Passageiro dono) {
        this.dono = dono;
        this.saldo = 0;
    }
    
    public Cartao() {}

    public double calcularTarifa(String m) {
        try {
            this.tarifa = 5;
            switch (m) {
                case "PASSE LIVRE +60":
                case "PASSE LIVRE +65":
                case "PCD":
                    this.tarifa = 0;
                    break;
                case "ESTUDANTE":
                    this.tarifa *= 0.5;
                    break;
                case "PASSE ANTECIPADO":
                    this.tarifa *= 1;
                    break;
                default:
                    System.out.println("Esta modalidade não está disponível.");
            }
        } catch (Exception e) {
            e.printStackTrace();
            System.out.println("Erro ao calcular tarifa.");
        }
        return this.tarifa;
    }

    public void setTarifa(double tarifa) {
        this.tarifa = tarifa;
    }

    public double getTarifa() {
        return this.tarifa;
    }

    public double recarregarSaldo(int numP) {
        this.saldo += numP * getTarifa();
        return this.saldo;
    }

    public double getSaldo() {
        return this.saldo;
    }

    public void setSaldo(double umSaldo) {
        this.saldo = umSaldo;
    }

    @Override
    public String toString() {
        return dono + " Tarifa: " + this.tarifa + " Saldo: " + this.saldo + " reais.";
    }
}
