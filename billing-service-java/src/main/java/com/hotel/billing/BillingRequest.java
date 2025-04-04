package com.hotel.billing;

import java.time.LocalDateTime;

public class BillingRequest {
    private Long pessoaId;
    private LocalDateTime dataEntrada;
    private LocalDateTime dataSaida;
    private int vagasGaragem;

    public Long getPessoaId() {
        return pessoaId;
    }

    public void setPessoaId(Long pessoaId) {
        this.pessoaId = pessoaId;
    }

    public LocalDateTime getDataEntrada() {
        return dataEntrada;
    }

    public void setDataEntrada(LocalDateTime dataEntrada) {
        this.dataEntrada = dataEntrada;
    }

    public LocalDateTime getDataSaida() {
        return dataSaida;
    }

    public void setDataSaida(LocalDateTime dataSaida) {
        this.dataSaida = dataSaida;
    }

    public int getVagasGaragem() {
        return vagasGaragem;
    }

    public void setVagasGaragem(int vagasGaragem) {
        this.vagasGaragem = vagasGaragem;
    }
}
