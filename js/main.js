if($(".btn-3").length){
    var a = 0;
}

if($(".modal").length){
    var i = 0;
    $(".modal").click(function() {
        if(a === 1){
            $(".moda").remove()
            a = 0;
        }

        if(i === 0){
            $("body").append(`
                <div class="mod">
                    <a class="b-box" href="/dashboard.php">
                        <div class="box">
                            <i class="fas fa-chart-line"></i>
                            <p>Dashboard</p>
                        </div>
                    </a>
                    <a class="b-box" href="/inbox.php">
                        <div class="box">
                            <i class="fas fa-inbox"></i>
                            <p>Inbox</p>
                        </div>
                    </a>
                    <a class="b-box" href="/setting.php">
                        <div class="box">
                            <i class="fas fa-cog"></i>
                            <p>Settings</p>
                        </div>
                    </a>
                </div>
            `)
            i = 1;
        }else{
            $(".mod").remove()
            i = 0;
        }
    })
}

if($(".btn-3").length){
    var a = 0;
    $(".btn-3").click(function() {
        if(i === 1){
            $(".mod").remove()
            i = 0;
        }

        if(a === 0){
            $("body").append(`
                <div class="moda">
                    <img class="btn-3 mr-0" src="https://icebeal.herokuapp.com/api/identicon/`+name+`.svg" />
                    <p class="name">`+name+`</p>
                    <p class="email">`+email+`</p>
                    <a class="b-box" href="/account.php">
                        <div class="box">
                            <i class="fas fa-cog"></i>
                            <p>Account Settings</p>
                        </div>
                    </a>
                    <a class="b-box" href="/logout.php">
                        <div class="box">
                            <i class="fas fa-arrow-right"></i>
                            <p>Logout</p>
                        </div>
                    </a>
                </div>
            `)
            a = 1;
        }else{
            $(".moda").remove()
            a = 0;
        }
    })
}