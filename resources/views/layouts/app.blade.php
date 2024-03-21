<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title') - Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        /* .select-right-answer-text {
    text-align: right;
    margin-top: 10px;
}

.choice-item {
    display: flex;
    align-items: center;
    margin-bottom: 5px;
}

.choice-item span {
    margin-right: 10px;
}

.choice-item .choice-input {
    flex-grow: 1;
    margin-right: 10px;
} */

        </style>

</head>

<body>
    <nav>
        <div class="container d-flex justify-content-between align-items-center">
            <img src="{{ asset('img/sourcee logo.png') }}" alt="logo" class="logo" />
            <a class="nav-link primaryColor" href="{{ route('logout') }}">Logout</a>
        </div>
    </nav>
    <div class="CampaignsPage ">
        @yield('content')
    </div>
    <script type="text/javascript">
        var APP_URL = "{{ config('app.url') }}";
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/campaign.js') }}"></script>
    <script src="{{ asset('js/campaign_questions.js') }}"></script>
    <script>
        function myFunction() {
        var searchBTN = document.getElementById("searchBTN");
        var cancelBtn = document.getElementById("cancelBtn");
        var searchIN = document.getElementById("searchIN");
        var Actiontext = document.getElementById("Actiontext");


        if (searchBTN.style.display === "none") {
            searchBTN.style.display = "block";
            Actiontext.style.display = "block";
            cancelBtn.style.display = "none";
            searchIN.style.display = "none";

        } else {
            searchBTN.style.display = "none";
            cancelBtn.style.display = "block";
            Actiontext.style.display = "none";
            searchIN.style.display = "block";
            searchIN.focus();

        }
        }


        function seacrhFilter() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchIN");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByClassName("picassoCampaignsListingPage");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByClassName("CmpTitle")[0];
                if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
                }       
            }
        }

        function toggleCheckbox(element) {
            element.classList.toggle('checked');
        }
    </script>
    @yield('scripts')
</body>
</html>