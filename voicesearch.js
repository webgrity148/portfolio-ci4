// const searchForm = document.querySelector("#search-form");
// const searchFormInput = searchForm.querySelector("input");
// const info = document.querySelector(".info");

// // Create speaking overlay div
// const speakingOverlay = document.createElement("div");
// speakingOverlay.id = "speaking-overlay";
// speakingOverlay.classList.add("deactivate"); // Initially hide it
// speakingOverlay.style.textAlign = "center"; // Center text
// speakingOverlay.innerHTML = `
//   <p id="recognized-text">Microphone is active</p>
//   <button id="microphone-off" type="button"><i class="fas fa-microphone"></i></button>
// `;
// document.body.appendChild(speakingOverlay);

// // Create audio element for microphone activation sound
// const micOnSound = new Audio('../sound/search-sound.mp3'); // Path to your sound file

// const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

// if (SpeechRecognition) {
//   const recognition = new SpeechRecognition();
//   recognition.continuous = true;

//   searchForm.insertAdjacentHTML("beforeend", '<button id="microphone" type="button"><i class="fas fa-microphone"></i></button>');
//   searchFormInput.style.paddingRight = "50px";

//   const micBtn = searchForm.querySelector("button#microphone");
//   const micIcon = micBtn.firstElementChild;

//   micBtn.addEventListener("click", micBtnClick);
//   function micBtnClick() {
//     if (micIcon.classList.contains("fa-microphone")) {
//       recognition.start(); // Start Voice Recognition
//       console.log("listening...");
//     } else {
//       recognition.stop(); // Stop Voice Recognition
//       console.log("listening...stop");
//     }
//   }

//   recognition.addEventListener("start", startSpeechRecognition);
//   function startSpeechRecognition() {
//     micIcon.classList.remove("fa-microphone");
//     micIcon.classList.add("fa-microphone-slash");
//     searchFormInput.focus();
//     speakingOverlay.classList.remove("deactivate"); // Show overlay
//     micOnSound.play(); // Play the microphone on sound
//     console.log("Voice activated, SPEAK");
//   }

//   recognition.addEventListener("end", endSpeechRecognition);
//   function endSpeechRecognition() {
//     micIcon.classList.remove("fa-microphone-slash");
//     micIcon.classList.add("fa-microphone");
//     searchFormInput.focus();
//     speakingOverlay.classList.add("deactivate"); // Hide overlay
//     console.log("Speech recognition service disconnected");
//   }

//   recognition.addEventListener("result", resultOfSpeechRecognition);
//   function resultOfSpeechRecognition(event) {
//     const current = event.resultIndex;
//     const transcript = event.results[current][0].transcript;

//     // Update the recognized text in the overlay
//     document.getElementById("recognized-text").textContent = transcript;

//     if (transcript.toLowerCase().trim() === "stop recording") {
//       recognition.stop();
//     } else if (!searchFormInput.value) {
//       searchFormInput.value = transcript;
//     } else {
//       if (transcript.toLowerCase().trim() === "go") {
//         searchForm.submit();
//       } else if (transcript.toLowerCase().trim() === "reset input") {
//         searchFormInput.value = "";
//       } else {
//         searchFormInput.value = transcript;
//       }
//     }
//   }

//   info.textContent = 'Voice Commands: "stop recording", "reset input", "go"';

//   // Handle microphone off button
//   const micOffBtn = document.getElementById("microphone-off");
//   micOffBtn.addEventListener("click", () => {
//     recognition.stop(); // Stop recognition
//     speakingOverlay.classList.add("deactivate"); // Hide overlay
//     micIcon.classList.remove("fa-microphone-slash");
//     micIcon.classList.add("fa-microphone"); // Reset icon
//   });

// } else { alert("not support");
//   console.log("Your Browser does not support speech Recognition");
//   info.textContent = "Your Browser does not support Speech Recognition";
// }

      const speechApiUrl = `https://speech.googleapis.com/v1/speech:recognize?key=AIzaSyCJ_etFkpGjwcgl3nlf1GBRPYrfZS6KwO4`;
      let mediaRecorder;
      let audioChunks = [];
      let audioContext;
      let analyser;
      let silenceTimeout;
      let isRecording = false; // New flag to track recording state
      const searchInputElem= document.getElementById("recognizedText");

      document.getElementById("startRecording").onclick = () => {
        navigator.mediaDevices.getUserMedia({ audio: true }).then((stream) => {
            $('#startRecording').css({color:'#bb262e'});
            $('#recognizedText').attr('placeholder','Listening...');
            $('#recognizedText').val('');
          audioContext = new AudioContext();
          analyser = audioContext.createAnalyser();
          const source = audioContext.createMediaStreamSource(stream);
          source.connect(analyser);

          mediaRecorder = new MediaRecorder(stream);
          mediaRecorder.start();
          isRecording = true; // Set recording flag

          mediaRecorder.ondataavailable = (event) => audioChunks.push(event.data);

          mediaRecorder.onstop = () => {
            //  alert("clear audio chunks");
            const audioBlob = new Blob(audioChunks, { type: "audio/wav" });
            sendAudioToGoogle(audioBlob);
            audioChunks = [];
          };

          checkSilence();
        //   document.getElementById("stopRecording").disabled = false;
          document.getElementById("startRecording").disabled = true;
        }).catch((error) => console.error("Error accessing the microphone:", error));
      };

    //   document.getElementById("stopRecording").onclick = () => {
    //     stopRecording();
    //   };

      function stopRecording() {
        if (isRecording) {
          mediaRecorder.stop();
          $('#startRecording').css({color:'#fff'});
          isRecording = false; // Update recording state
          if (audioContext && audioContext.state !== "closed") {
            audioContext.close();
          }
          document.getElementById("startRecording").disabled = false;
        //   document.getElementById("stopRecording").disabled = true;
          clearTimeout(silenceTimeout);
        }
      }

      function checkSilence() {
        const bufferLength = analyser.fftSize;
        const dataArray = new Uint8Array(bufferLength);

        function analyzeAudio() {
          if (!isRecording) return; // Stop analyzing if recording has ended

          analyser.getByteTimeDomainData(dataArray);
          const isSilent = dataArray.every(value => Math.abs(value - 128) < 5);

          if (isSilent) {
            if (!silenceTimeout) {
              silenceTimeout = setTimeout(() => {
                stopRecording(); // Stop recording after 2 seconds of silence
              }, 2000); // 2 seconds of silence before stopping
            }
          } else {
            clearTimeout(silenceTimeout); // Reset the silence timer if noise is detected
            silenceTimeout = null;
          }

          requestAnimationFrame(analyzeAudio);
        }

        analyzeAudio();
      }

      function sendAudioToGoogle(audioBlob) {
        const reader = new FileReader();
        reader.onloadend = () => {
          const audioBase64 = reader.result.split(",")[1];
          const requestBody = {
            config: {
              encoding: "WEBM_OPUS",
              sampleRateHertz: 48000,
              languageCode: "en-US",
            },
            audio: {
              content: audioBase64,
            },
          };

          fetch(speechApiUrl, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(requestBody),
          })
          .then((response) => response.json())
          .then((data) => {
            if (data.results && data.results.length > 0) {
              const transcript = data.results
                .map((result) => result.alternatives[0].transcript)
                .join(" ");
                searchInputElem.value = transcript.trim();
              if (transcript.trim() !== "") {
                $('#recognizedText').attr('placeholder','Search for a product or your Zipcode to find local deals');
                  $('#search-form').submit();
              }else{
                $('#recognizedText').attr('placeholder','We could\'nt hear you, please speak again...');
              }
            }
            else {
                $('#recognizedText').attr('placeholder','We could\'nt hear you, please speak again...');
            }
          })
          .catch((error) => console.error("Error sending audio to Google:", error));
        };

        reader.readAsDataURL(audioBlob);
      }


