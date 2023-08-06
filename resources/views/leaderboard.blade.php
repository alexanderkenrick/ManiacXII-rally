<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
            integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        body {
            height: 100vh;
            padding: 0 10rem;
            background-color: #0C2548;
        }

        .leaderboard {
            max-width: 1845px;
        }

        .rallyPoint {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
        }

        #btn-logout {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 2;
        }

        .nes-dialog.is-rounded,
        .nes-btn,
        .nes-textarea {
            border-image-repeat: stretch !important;
        }

        .nes-btn {
            font-family: 'Broken Console', sans-serif !important;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px 30px;
            border: 1px solid #888;
            border-radius: 20px;
            width: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .modal-header {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .close {
            color: #aaa;
            font-size: 32px;
            font-weight: bold;
        }

        .close:hover, .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .divider {
            width: 100%;
            border: 2px solid #aaa;
            border-radius: 14px
        }

        #modal-item {
            display: flex;
            flex-direction: column;
            width: 100%;
            margin-top: 20px;
            gap: 20px;
        }
    </style>
</head>
<body class="d-flex justify-content-center">
    <div class="h-100 w-100 overflow-auto leaderboard">
        <table class="table table-secondary">
            <thead class="table-dark">
                <tr>
                    <th class="text-center fs-4 py-4">Nama Tim</th>
                    <th class="text-center fs-4 py-4">Rally Point</th>
                    <th class="text-center fs-4 py-4">Game Besar Point</th>
                    <th class="text-center fs-4 py-4">Total Point</th>
                </tr>
            </thead>
            <tbody>
            @php
                // 10 tim yg lolos penyisihan
                $cnt = 1;
            @endphp
            @foreach($teamsData as $team => $data)
                @if($cnt <= 10)
                    <tr class="table-success">
                        <td class="text-center fs-5 fw-bold py-4">{{ $team }}</td>
                        <td class="text-center fs-5 py-4 rallyPoint">{{ $data["rally_point"]  }} <button id="{{ $data["team_id"] }}" class="w-75 btn btn-primary mt-2 rallyButton">History</button></td>
                        <td class="text-center fs-5 py-4"><div class="d-flex flex-column align-items-center justify-content-center">{{ $data["game_besar_point"] }} <a id="{{ $data["team_id"] }}" class="w-75 btn btn-primary mt-2 rincian">Rincian</a></div></td>
                        <td class="text-center fs-5 fw-semibold py-4">{{ $data["total_point"] }}</td>
                    </tr>
                    @php($cnt++)
                @else
                    <tr>
                        <td class="text-center fs-5 fw-bold py-4">{{ $team }}</td>
                        <td class="text-center fs-5 py-4 rallyPoint">{{ $data["rally_point"]  }} <button id="{{ $data["team_id"] }}" class="w-75 btn btn-primary mt-2 rallyButton">History</button></td>
                        <td class="text-center fs-5 py-4 w-25"><div class="d-flex flex-column align-items-center justify-content-center">{{ $data["game_besar_point"] }} <a id="{{ $data["team_id"] }}" class="w-75 btn btn-primary mt-2 rincian">Rincian</a></div></td>
                        <td class="text-center fs-5 fw-semibold py-4">{{ $data["total_point"] }}</td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
    @if (Auth::check())
        <button class="nes-btn is-error" id="btn-logout" href="{{ route('logout') }}"
                onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Logout') }}</button>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    @endif

    <!-- MODAL -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <!-- HEADER -->
            <div class="modal-header">
                <h2 id="modal-header__title"></h2>
                <span class="close">&times;</span>
            </div>
            <div class="divider"></div>
            <!-- ITEM -->
            <div id="modal-item">
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById("myModal");
        const closeModal = document.querySelector(".close");
        const buttons = document.querySelectorAll(".rallyButton");
        const gameBesButtons = document.querySelectorAll(".rincian");
        const modalItem = document.getElementById("modal-item")
        const modalHeaderTitle = document.getElementById("modal-header__title");

        const getHistory = async (id) => {
            modalItem.innerHTML = "";
            modalHeaderTitle.innerHTML = "History";
            console.log(id);
            let points;
            let posts;
            await $.ajax({
                type: 'POST',
                url: '{{ route('admin.history') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id,
                },
                success: function (data) {
                    points = data[0].history;
                    posts = data[0].postNames;
                }
            });

            for (let i = 0 ; i < points.length; i++) {
                let p = document.createElement("p");
                let span = document.createElement("span");
                let spanPoint = document.createElement("span");
                let spanPos = document.createElement("span");
                let point = points[i].point;
                let post = posts[i];

                p.classList.add("fs-5", "mb-1");

                spanPoint.classList.add("fw-bold");
                spanPoint.append(point);

                spanPos.classList.add("fw-bold");
                spanPos.append(post);

                span.append("Mendapatkan ", spanPoint, " Poin dari Pos ", spanPos);
                p.append(span);

                modalItem.append(p);
            }

            modal.style.display = "block";
        }

        const getRincian = async (id) => {
            modalItem.innerHTML = "";
            modalHeaderTitle.innerHTML = "Rincian Salvos";
            let keputusan, playerHp, totalDamage, turn, gameBesPoint, revive, playerHpPercent;
            await $.ajax({
                type: 'POST',
                url: '{{ route('admin.rincian') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id,
                },
                success: function (data) {
                    if (data[0].status) {
                        revive = data[0].revive;
                        keputusan = data[0].keputusan;
                        playerHp = data[0]['player_hp'];
                        playerHpPercent = (playerHp / 100);
                        totalDamage = data[0]['total_damage'];
                        turn = data[0].turn;
                        gameBesPoint = data[0]['game_bes_point'];
                        console.log(revive);

                        // Keputusan
                        let pKeputusan = document.createElement('p');
                        pKeputusan.classList.add('display-4', 'fw-normal', 'text-center');
                        (keputusan === "Menang") ? pKeputusan.classList.add('text-success') : pKeputusan.classList.add('text-danger');

                        // Player HP
                        let divPlayerHp = document.createElement('div');
                        let pPlayerHp = document.createElement('p');
                        let divProgress = document.createElement('div');
                        divProgress.classList.add('progress');
                        let divProgressBar = document.createElement('div');
                        divProgressBar.classList.add('progress-bar');
                        divProgressBar.style.width = playerHpPercent + "%";
                        divProgressBar.ariaRoleDescription = "progressbar";
                        divProgressBar.ariaLabel = "Player HP";
                        divProgressBar.ariaValueNow = playerHpPercent;
                        divProgressBar.ariaValueMin = "0";
                        divProgressBar.ariaValueMax = "100";
                        divProgress.append(divProgressBar);
                        divPlayerHp.append(pPlayerHp, divProgress);

                        let pTotalDamage = document.createElement('p');
                        let pTurn = document.createElement('p');
                        let pGameBesPoint = document.createElement('p');
                        let pRevive = document.createElement('p');

                        pKeputusan.innerHTML = keputusan;
                        pPlayerHp.innerHTML = "Player HP : " + playerHp;
                        pTotalDamage.innerHTML = "Total Damage : " + totalDamage;
                        pTurn.innerHTML = "Total Turn : " + turn;
                        pGameBesPoint.innerHTML = "Point : " + gameBesPoint;
                        pRevive.innerHTML = "Revive : " + revive;

                        modalItem.append(pKeputusan, divPlayerHp, pTotalDamage, pTurn, pGameBesPoint, pRevive);
                    } else {
                        let h1 = document.createElement('h1');
                        h1.classList.add('display-4', 'fw-normal', 'text-danger', 'text-center');
                        h1.innerHTML = "Belum Main";
                        modalItem.append(h1);
                    }
                }
            });

            modal.style.display = "block";
        }

        gameBesButtons.forEach((button) => {
            button.addEventListener('click', (event) => {
                getRincian(button.id);
            })
        })

        // Open modal
        buttons.forEach((button) => {
            let id = button.id;
            button.addEventListener('click', (event) => {
                // console.log(id);
                // getHistory(id).then()
                getHistory(id);
            })
        });

        // Close Modal
        closeModal.addEventListener('click', () => {
            modal.style.display = "none";
        });

        // Close Modal
        window.addEventListener('click', (event) => {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        });
    </script>
</body>
</html>
