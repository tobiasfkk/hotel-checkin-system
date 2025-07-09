package com.hotel.billing;

import java.time.LocalDateTime;

/**
 * DTO para requisições de cálculo de faturamento.
 * Contém dados necessários para calcular o valor da hospedagem.
 * 
 * @author Hotel Check-in System
 * @version 1.0.0
 */
public class BillingRequest {
    
    /** ID da pessoa hospedada */
    private Long pessoaId;
    
    /** Data e hora de entrada no hotel */
    private LocalDateTime dataEntrada;
    
    /** Data e hora de saída do hotel */
    private LocalDateTime dataSaida;
    
    /** Número de vagas de garagem utilizadas */
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
