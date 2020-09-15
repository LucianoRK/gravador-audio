<script>
    //Configura variaveis iniciais
    URL = window.URL || window.webkitURL;

    let gumStream;
    let rec;
    let input;

    let AudioContext = window.AudioContext || window.webkitAudioContext;
    let audioContext

    let recordButton = document.getElementById("recordButton");
    let stopButton = document.getElementById("stopButton");
    let pauseButton = document.getElementById("pauseButton");

    //Adiciona o evento nos botões
    recordButton.addEventListener("click", startRecording);
    stopButton.addEventListener("click", stopRecording);
    pauseButton.addEventListener("click", pauseRecording);

    function startRecording() {
        let constraints = {
            audio: true,
            video: false
        }

        //Seta status nos botões
        recordButton.disabled = true;
        stopButton.disabled = false;
        pauseButton.disabled = false

        navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {

            audioContext = new AudioContext();

            //Mostra o formato de áudio
            console.log("Formato: " + audioContext.sampleRate / 1000 + "kHz")
            //Declara a gumStram
            gumStream = stream;

            //Cria o input de midia
            input = audioContext.createMediaStreamSource(stream);

            // Cria o objeto de gravação 
            rec = new Recorder(input, {
                numChannels: 1
            })

            //Começa o processo de gravação
            rec.record()

        }).catch(function(err) {
            //Atualiza o status dos botões
            recordButton.disabled = false;
            stopButton.disabled = true;
            pauseButton.disabled = true
        });
    }

    //Pausa a gravação
    function pauseRecording() {
        if (rec.recording) {
            //pause
            rec.stop();
            pauseButton.innerHTML = "Continuar";
        } else {
            //resume
            rec.record()
            pauseButton.innerHTML = "Pause";
        }
    }

    //Para a gravação
    function stopRecording() {

        //Atualiza o status dos botões
        stopButton.disabled = true;
        recordButton.disabled = false;
        pauseButton.disabled = true;

        //Renomeia o botão
        pauseButton.innerHTML = "Pause";

        //Para a gravação
        rec.stop();

        //Para o acesso ao mic
        gumStream.getAudioTracks()[0].stop();

        //Cria um Wav
        rec.exportWAV(createDownloadLink);
    }

    //Cria a lista de reprodução
    function createDownloadLink(blob) {

        let url = URL.createObjectURL(blob);
        let au = document.createElement('audio');
        let li = document.createElement('li');
        let link = document.createElement('a');
        let btnSalvar = document.createElement('button');

        //Gera um nome para o arquivo
        let filename = new Date().toISOString();

        //Adiciona o controlador de mídio no <audio>
        au.controls = true;
        au.src = url;

        //Monta a opção de salvar
        link.href = url;
        link.download = filename + ".wav";

        //Adiciona o nome a lista
        li.appendChild(document.createTextNode(filename + ".wav "))

        //Adiciona o áudio na lista
        li.appendChild(au);

        //Deixa o player em 100%
        au.classList.add("w-100");

        //adiciona o link a lista
        li.appendChild(link);
        link.appendChild(btnSalvar);
        btnSalvar.classList.add("btn");
        btnSalvar.classList.add("btn-success");
        btnSalvar.classList.add("mt-1");
        btnSalvar.classList.add("mb-3");
        btnSalvar.innerHTML = "Baixar";
  
        //link de uplod
        let xhr = new XMLHttpRequest();
        let fd = new FormData();
        fd.append("audio_data", blob, filename);
        xhr.open("POST", "<?= base_url('store') ?>", true);
        xhr.send(fd);

        recordingsList.appendChild(li);
    }
</script>