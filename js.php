<script src="https://cdnjs.cloudflare.com/ajax/libs/xterm/3.14.5/xterm.min.js" integrity="sha512-2PRgAav8Os8vLcOAh1gSaDoNLe1fAyq8/G3QSdyjFFD+OqNjLeHE/8q4+S4MEZgPsuo+itHopj+hJvqS8XUQ8A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    var c = 0;

    $(".mg-2").click(function() {
        if(c === 0){
            $(".left-25").eq(1).append(`<div class="accord"></div>`);


            $(".accord").append(`
                <a class="b-box" id="black2">
                    <div class="box">
                    <i class="fa-solid fa-terminal" style="color: #4834d4;"></i>
                        <p>Run</p>
                    </div>
                </a>`);

            $("#black2").click(function() {
                $('.wrap').append(`
                    <div class="blink"></div>
                    
                    <div class="inner"></div>
                `)

                let socket = new WebSocket("ws://<?= $ip ?>:3000/websocket");

                var baseTheme = {
    foreground: '#F8F8F8',
    background: '#2D2E2C',
    selection: '#5DA5D533',
    black: '#1E1E1D',
    brightBlack: '#262625',
    red: '#CE5C5C',
    brightRed: '#FF7272',
    green: '#5BCC5B',
    brightGreen: '#72FF72',
    yellow: '#CCCC5B',
    brightYellow: '#FFFF72',
    blue: '#5D5DD3',
    brightBlue: '#7279FF',
    magenta: '#BC5ED1',
    brightMagenta: '#E572FF',
    cyan: '#5DA5D5',
    brightCyan: '#72F0FF',
    white: '#F8F8F8',
    brightWhite: '#FFFFFF'
  };

                var term = new window.Terminal({
                    fontFamily: '"Cascadia Code", Menlo, monospace',
                    theme: baseTheme,
                    cursorBlink: true
                });
                    term.open(document.querySelector('.inner'));

                    var shellprompt = '$ ';

                    term.prompt = () => {
      term.write('\r\n$ ');
    };

    // TODO: Use a nicer default font
    term.writeln([
      '    Welcome to WebHost! You are on Virtual Machine',
      '',
      ' ┌ \x1b[1mFeatures\x1b[0m ──────────────────────────────────────────────────────────────────┐',
      ' │                                                                            │',
      ' │  \x1b[31;1mApps just work                         \x1b[32mPerformance\x1b[0m                        │',
      ' │   Xterm.js works with most terminal      Xterm.js is fast and includes an  │',
      ' │   apps like bash, vim and tmux           optional \x1b[3mWebGL renderer\x1b[0m           │',
      ' │                                                                            │',
      ' │  \x1b[33;1mAccessible                             \x1b[34mSelf-contained\x1b[0m                     │',
      ' │   A screen reader mode is available      Zero external dependencies        │',
      ' │                                                                            │',
      ' │  \x1b[35;1mUnicode support                        \x1b[36mAnd much more...\x1b[0m                   │',
      ' │   Supports CJK 語 and emoji \u2764\ufe0f            \x1b[3mLinks\x1b[0m, \x1b[3mthemes\x1b[0m, \x1b[3maddons\x1b[0m,            │',
      ' │                                          \x1b[3mtyped API\x1b[0m, \x1b[3mdecorations\x1b[0m            │',
      ' │                                                                            │',
      ' └────────────────────────────────────────────────────────────────────────────┘',
      ''
    ].join('\n\r'));
    $(".blink").click(function(){
        $(".blink").remove()
        $(".inner").remove()
    })

    term.writeln('Below is a simple emulated backend, try running `help`.');
    prompt(term);

    term.onData(e => {
      switch (e) {
        case '\u0003': // Ctrl+C
          term.write('^C');
          prompt(term);
          break;
        case '\r': // Enter
          runCommand(term, command);
          command = '';
          break;
        case '\u007F': // Backspace (DEL)
          // Do not delete the prompt
          if (term._core.buffer.x > 2) {
            term.write('\b \b');
            if (command.length > 0) {
              command = command.substr(0, command.length - 1);
            }
          }
          break;
        default:
	  if (e >= String.fromCharCode(0x20) && e <= String.fromCharCode(0x7E) || e >= '\u00a0') {
	    command += e;
            term.write(e);
          }
      }
    });

    function prompt(term) {
    command = '';
    term.write('\r\n$ ');
  }

  var command = '';
  
  function runCommand(term, text) {
    const command = text;
    if (command.length > 0) {
      term.writeln('');
      console.log(command)
      socket.send(command);
    }else{
        prompt(term)
    }
  }

    socket.onmessage = function(event) {
	    term.write(event.data);
        prompt(term);
    };
});
            
            <?php if($ok === 0){?>
            $(".accord").append(`
                <a class="b-box">
                    <div class="box" id="green">
                        <i class="fa-solid fa-circle-play green"></i>
                        <p>Start</p>
                    </div>
                </a>
            `)
            <?php echo '$("#green").click(function() {
                fetch("/exe.php?active=on&container='.$name.'")
                .then(reload => {
                    location.reload();
                });
            }); c = 1;'; 
            }else{ ?>
            $(".accord").append(`
                <a class="b-box" id="red">
                    <div class="box">
                        <i class="fa-solid fa-circle-stop red"></i>
                        <p>Stop</p>
                    </div>
                </a>
            `)
            <?php echo
            '$("#red").click(function() {
                fetch("/exe.php?active=off&container='.$name.'")
                .then(reload => {
                    location.reload();
                });
            });
            
            c = 1;';
            } ?>

            $(".accord").append(`
                <a class="b-box" id="black">
                    <div class="box">
                        <i class="fa-solid black fa-trash"></i>
                        <p>Delete</p>
                    </div>
                </a>`);
            
            <?php echo '$("#black").click(function() {
                fetch("/exe.php?active=delete&container='.$name.'&user='.$user.'&name='.$realname.'")
                .then(reload => {
                    location.reload();
                });
            }); c = 1;'; ?>
        }else{
            $(".left-25").eq(1).children(".accord").remove()
            c = 0;
        }
    })
</script>