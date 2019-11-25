/*
  Basic Voice User Interface.

  It uses the Web Speech API (experimental) for speech-to-text and text-to-speech operations.
  Tested in Chrome 57+, Firefox 70+, and Safari 10.1+.
  Please, notice that speech-to-text capability does not work in Safari and Firefox.
*/
let $speechInput,
  $recBtn,
  messageInternalError = "Oh no, there has been an internal server error",
  messageSorry = "I'm sorry, I don't have the answer to that yet.";

$(document).ready(function() {
  $speechInput = $("#userquery");
  $recBtn = $("#rec");

  // get the text inserted by the user and process it
  $speechInput.keypress(function(event) {
    if (event.which === 13) { // 13 is carriage return (new line)
      event.preventDefault();
      // add the new message in the chat area
      createBubbleChat($speechInput.val(), "self");
      // send the text to the server
      send();
      // clear the input
      $speechInput.val('');
    }
  });
  $recBtn.on("click", function(event) {
    // start or stop speech recognition
  });
});

/* send the input message for further processing */
function send() {
  let text = $speechInput.val();
  $.ajax({
    type: "POST",
    url: "process.php",
    data: {submit: true, message: text},

    success: function(data) {
      respond(data);
    },
    error: function() {
      respond(messageInternalError);
    }
  });
}

/* handle the response coming from the server */
function respond(val) {
  if (val === "") {
    val = messageSorry;
  }

  // add the new message in the chat area
  createBubbleChat(val, "other");
}

//--- utility functions ---//

/* Create a new "chat bubble" in the chat area */
function createBubbleChat(val, type){
  $(".chat").append('<li class="'+type+'"><div class="msg"><p>'+val+'</p></div></li>');
  window.scrollTo(0,document.body.scrollHeight);
}
