<?php 	include_once($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>
<body>
    <div id="wrapper-sidebar" class="active">
        <!-- Sidebar Holder -->
        <nav id="sidebar" class="active">
            <div class="sidebar-header">
                <h3 class="anim">MANGTCOIN</h3>
            </div>

            <ul>
                <li>
                    <a href="#mainmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">메인</a>
                    <ul class="collapse list-unstyled" id="mainmenu">
                        <li>
                            <a href="/index.php#tab1">시작</a>
                        </li>
                        <li>
                            <a href="/index.php#tab2">맹트코인이란?</a>
                        </li>
                        <li>
                            <a href="/index.php#tab3">체험방법</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#usermenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">계정</a>
                    <ul class="collapse list-unstyled" id="usermenu">
                        <?php
                            if(!isset($_SESSION["id"])) {

                            ?>
                                <li>
                                    <a href="login.php">로그인</a>
                                </li>
                                <li>
                                    <a href="signup.php">회원가입</a>
                                </li>
                            <?php
                            }
                            else {
                            ?>
                                <li>
                                    <a href="/logout.php">로그아웃</a>
                                    
                                </li>
                                <li>
                                    <a href="/edit_profile.php">계정수정</a>
                                </li>
                            <?php }
                        ?>
                    </ul>
                </li>
                <li>
                    <a href="#walletmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">거래</a>
                    <ul class="collapse list-unstyled" id="walletmenu">
                        <li>
                            <a href="/coins/send_coin.php">송금하기</a>
                        </li>
                        <li>
                            <a href="/wallet/manage_wallet.php">계좌관리</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#documenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">자료</a>
                    <ul class="collapse list-unstyled" id="documenu">
                        <li>
                            <a href="/blockchain.php">체인</a>
                        </li>
                        <li>
                            <a href="/mining.php">채굴</a>
                        </li>
                        <li>
                            <a href="https://github.com/mangtang1/portfolio">코드</a>
                        </li>
                    </ul>

                </li>
            </ul>

        </nav>
            <label>
        <div id="content-sidebar" class="active">
                <button onclick="togside();" type="button" id="sidebarCollapse" class="navbar-btn active">
                    <span></span>
                    <span></span>
                    <span></span>

                </button>
        </div>
            </label>
        <script>
            sw=1;
            function togside()
            {
                if(sw==1)
                {
                    document.getElementById('wrapper-sidebar').classList.remove('active');
                    document.getElementById('sidebar').classList.remove('active');
                    document.getElementById('content-sidebar').classList.remove('active');
                    document.getElementById('sidebarCollapse').classList.remove('active');
                    sw=0;
                }
                else
                {
                    document.getElementById('wrapper-sidebar').classList.add('active');
                    document.getElementById('sidebar').classList.add('active');
                    document.getElementById('content-sidebar').classList.add('active');
                    document.getElementById('sidebarCollapse').classList.add('active');
                    sw=1;
                }
            }
            window.onload = function(){
                let checklist = document.querySelectorAll('input.inp');
                checklist.forEach((tar) => {
                    tar.addEventListener('keyup', function(){able_but('input.inp', 'button.sub')});
                });
            };
        </script>
    </div>

        

    
</body>

</html>