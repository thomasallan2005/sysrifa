$(document).ready(function() {

    $('.btn-salvar').click(function(e) {
        e.preventDefault()

        let dados = $('#form-comprador').serialize()

        dados += `&operacao=${$('.btn-salvar').attr('data-operation')}`

        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            assync: true,
            data: dados,
            url: 'src/comprador/modelo/salvar-comprador.php',
            success: function(dados){
                Swal.fire({
                    title: 'Sysrifa',
                    text: dados.mensagem,
                    icon: dados.tipo,
                    cofirmButtonText: 'OK'
                })

                $('#modal-comprador').modal('hide')
            }
        })
    })
})