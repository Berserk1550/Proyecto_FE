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

document.addEventListener("DOMContentLoaded", () => {

    mostarPrograma();
});
