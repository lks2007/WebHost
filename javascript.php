<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    var c = 0;

    $(".mg-2").click(function() {
        if(c === 0){
            $(".left-25").eq(1).append(`<div class="accord"></div>`);

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
                fetch("/execute.php?active=on&container='.$name.'")
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
                fetch("/execute.php?active=off&container='.$name.'")
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
                fetch("/execute.php?active=delete&port='.$port_container.'&container='.$name.'&user='.$user.'&name='.$realname.'")
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