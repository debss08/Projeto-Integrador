$(document).ready(function () {
    const botaoMenu = $("#opennavBar");
    const abreMenu = $("#abrirMenu");
    const fechaMenu = $("#fecharMenu");
    const sidebar = $("#navBar");

    function toggleButtons(btn1, btn2) {
        btn1.toggle();
        btn2.toggle();
    }

    function ajustarBotao() {
        const largura = sidebar.outerWidth(true);
        botaoMenu.css("left", largura + "px");
    }

    function abrirMenu() {
        sidebar.removeClass('fechado');
        setTimeout(() => {
            ajustarBotao();
            toggleButtons(abreMenu, fechaMenu);
            $("#content").css("left", "300px");
            $("#content").css("width", "calc(100% - 300px)");
        }, 10);
    }

    function fecharMenu() {
        sidebar.addClass('fechado');
        setTimeout(() => {
            ajustarBotao();
            toggleButtons(abreMenu, fechaMenu);
            $("#content").css("left", "80px");
            $("#content").css("width", "calc(100% - 80px)");
        }, 10);
    }

    // Começa fechado
    setTimeout(() => {
        ajustarBotao();
        fecharMenu();
    }, 10);

    botaoMenu.on("click", function () {
        const estaFechado = sidebar.hasClass('fechado');
        if (estaFechado) {
            abrirMenu();
        } else {
            fecharMenu();
        }
    });

    // Barra de pesquisa

    $('#searchFor-input').on('keyup', function() {
        var termo = $(this).val().toLowerCase();

        $('.item-book,.item-emprestimo').each(function() {
        var texto = $(this).text().toLowerCase();
        $(this).toggle(texto.includes(termo));
        });
    });
});
