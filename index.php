<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
</head>
<body>
    <div id="tabella-container"></div>
    <button id="crea-riga">Crea Persona</button>
    <div id="dialog" title="">
        <div id="crud-container">
            <table>
                <tr>
                    <td>
                        <label for="nome">Nome</label>
                    </td>
                    <td>
                        <label for="cognome">Cognome</label>
                    </td>
                    <td>
                        <label for="email">Email</label>
                    </td>
                    <td rowspan="2" valign="bottom">
                        <button id="nuova-riga">Inserisci Persona</button>
                        <button id="modifica-riga">Modifica Persona</button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" id="id">
                        <input type="text" id="nome">
                    </td>
                    <td>
                        <input type="text" id="cognome">
                    </td>
                    <td>
                        <input type="email" id="email">
                    </td>
                </tr>
            </table>
        </div>
    </div>
    

    <script type="text/javascript">
        let persone;
        let tabellaContainer = document.querySelector("#tabella-container");
        let inserisciBtn = document.querySelector('#nuova-riga');
        inserisciBtn.addEventListener('click', inserisciPersona)
        let modificaBtn = document.querySelector('#modifica-riga');
        modificaBtn.addEventListener('click', modificaPersona);

        generaTabella();
        
        function generaTabella(){
            fetch('./php/select.php', {
                method: 'POST',
                header: {
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                persone = data;
                console.log('Dati ricevuti: ', data);
                let tabella = `
                <table border=1>
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Nome</td>
                            <td>Cognome</td>
                            <td>Email</td>
                            <td>Azione</td>
                        </tr>
                    </thead>
                    <tbody>
                        ${generaRighe(data)}
                    </tbody>
                </table>
                `;
                tabellaContainer.insertAdjacentHTML('beforeend', tabella);
                //let modificaBottoni = document.querySelectorAll(".modifica-persona");
                let eliminaBottoni = document.querySelectorAll(".elimina-persona");
                /*for(let bott of modificaBottoni){
                    bott.addEventListener('click', selezionaPersona);
                }*/

                for(let bott of eliminaBottoni){
                    bott.addEventListener('click', eliminaPersona);
                }

            })
            .catch((error) => {
                console.error('Errore: ', error);
            });
        }

        function generaRighe(persone){
            let righe = '';
            persone.forEach(persona => {
                let riga = `
                <tr>
                    <td>${persona.id}</td>
                    <td>${persona.nome}</td>
                    <td>${persona.cognome}</td>
                    <td>${persona.email}</td>
                    <td>
                        <button class="modifica-persona" data-val="${persona.id}">Modifica</button>
                        <button class="elimina-persona" data-val="${persona.id}">Elimina</button>
                    </td>
                </tr>
                `;

                righe += riga;
            });
            return righe;
        }

        function inserisciPersona(){
            
            nome=document.getElementById("nome").value;
            cognome=document.getElementById("cognome").value;
            email=document.getElementById("email").value;
            
            console.log(nome);
            console.log(cognome);
            console.log(email);

            const formData = new FormData();
            formData.append('nome', nome)
            formData.append('cognome', cognome)
            formData.append('email', email)

            fetch('./php/insert.php', {
                method: 'POST',
                header: {
                    "Content-Type": "application/json"
                },
                body: formData
            })
            .then(response=>response.json())
            .then(data=>{
                console.log(data);
                aggiornaTabella();
                $( "#dialog" ).dialog( "close" );
            })
            .catch((error)=>{
                console.error('Errore: ', error);
            });

        }
        
        function selezionaPersona(e){

            let id = e.target.getAttribute('data-val');
            console.log('Seleziono persona: ', id);
            const formData = new FormData();
            formData.append('id', id)

            fetch('./php/selectById.php', {
                method: 'POST',
                header: {
                    "Content-Type": "application/json"
                },
                body: formData
            })
            .then(response=>response.json())
            .then(data=>{
                persona = data[0];
                console.log(data);
                document.getElementById("nome").value=persona.nome;
                document.getElementById("cognome").value=persona.cognome;
                document.getElementById("email").value=persona.email;
                document.getElementById("id").value=persona.id;
            })
            .catch((error)=>{
                console.error('Errore: ', error);
            });

        }

        function modificaPersona(e){

            let id = document.getElementById("id").value;
            let nome = document.getElementById("nome").value;
            let cognome = document.getElementById("cognome").value;
            let email = document.getElementById("email").value;
            console.log('Modifico persona: ', id);
            const formData = new FormData();
            formData.append('id', id)
            formData.append('nome', nome)
            formData.append('cognome', cognome)
            formData.append('email', email)

            fetch('./php/update.php', {
                method: 'POST',
                header: {
                    "Content-Type": "application/json"
                },
                body: formData
            })
            .then(response=>response.json())
            .then(data=>{
                aggiornaTabella();
            })
            .catch((error)=>{
                console.error('Errore: ', error);
            });

        }

        function eliminaPersona(e){

            let id = e.target.getAttribute('data-val');
            console.log('Elimino persona: ', id);
            const formData = new FormData();
            formData.append('id', id)

            fetch('./php/delete.php', {
                method: 'POST',
                header: {
                    "Content-Type": "application/json"
                },
                body: formData
            })
            .then(response=>response.json())
            .then(data=>{
                console.log(data);
                
            })
            .catch((error)=>{
                console.error('Errore: ', error);
            });

        }   

        function aggiornaTabella(){

            let tabella=document.querySelector('table');
            tabellaContainer.removeChild(tabella)
            generaTabella();

        }
        
        $( function() {
            $( "#dialog" ).dialog({
                autoOpen: false,
                width: 1000,
                height: 200,
            });
        
            /*$( "#crea-riga" ).on( "click", function() {
                $( "#dialog" ).dialog( 'option', 'title', 'Inserisci persona');
                $( "#nuova-riga" ).show();
                $( "#modifica-riga" ).hide();
                $( "#dialog" ).dialog( "open" );
            });*/
            $( ".modifica-persona" ).on( "click", function() {
                alert("ci passa");
                $( "#dialog" ).dialog( 'option', 'title', 'Modifica persona');
                $( "#nuova-riga" ).hide();
                $( "#modifica-riga" ).show();
                $( "#dialog" ).dialog( "open" );
            });
        } );
        
    </script>

</body>
</html>