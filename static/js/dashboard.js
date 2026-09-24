function mostarPrograma() {

    const abrir_medalla = document.getElementById("medalla_programa");
    const texto_programa = document.getElementById("texto_programa");

    abrir_medalla.addEventListener("click", () => {

        texto_programa.style.display = "flex";

        setTimeout(() => {
            texto_programa.style.display = "none";
        }, 2000);
    });
}

function abrirEditarPerfil() {
    const boton_editar = document.getElementById("perfil");
    const menu_perfil = document.getElementById("menu_perfil");

    boton_editar.addEventListener("click", () => {

        if (menu_perfil.style.display === "block") {

            menu_perfil.style.display = "none";

        } else {

            menu_perfil.style.display = "block";

        }
    });
}

function desbloqueaFases () {}

document.addEventListener("DOMContentLoaded", () => {

    mostarPrograma();

    abrirEditarPerfil();
});