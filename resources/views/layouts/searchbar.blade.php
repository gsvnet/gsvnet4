<div class="fixed top-0 dark:bg-[#161616] bg-[#d9e0e1] w-full flex flex-row z-50 max-w-7xl">
    <div class="md:hidden pt-4">
        <button class="navbar-burger flex items-center text-black dark:text-white p-3 ml-5">
            <svg class="block h-5 w-5 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <title>Mobile menu</title>
                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
            </svg>
        </button>
    </div>
    
    <x-navigation.search-input />

    <div class="dark:text-white md:hidden mr-5 text-black flex-row my-auto">
        <img src="{{ asset('/images/Logo-GSV-klein-icon.png') }}" alt="Logo GSV" class="mx-auto" x-bind:class="darkMode ? 'h-8 w-8'  : 'hidden'" />
        <img src="{{ asset('/images/Logo-GSV-klein-icon-zwart.png') }}" alt="Logo GSV" class="mx-auto" x-bind:class="darkMode ? 'hidden' : 'h-8 w-8'" />
    </div>

    <x-navigation.dark-toggle/>

    @include('layouts.navigation-mobile')
    
</div>

<script>
    // Search
    const dropdownButton = document.getElementById("dropdown-button");
    const dropdown = document.getElementById("dropdown");
    const dropdownOptions = document.querySelectorAll('.dropdown-option');

    dropdownButton.addEventListener("click", function () {
        dropdown.classList.toggle("hidden");
    });

    dropdownOptions.forEach(option => {
        option.addEventListener('click', function () {
            const selectedText = option.textContent.trim();
            
            dropdownButton.textContent = `${selectedText}`;

            dropdown.classList.add('hidden');
        });
    });

    // Burger menus
    document.addEventListener('DOMContentLoaded', function() {
        // open
        const burger = document.querySelectorAll('.navbar-burger');
        const menu = document.querySelectorAll('.navbar-menu');

        if (burger.length && menu.length) {
            for (var i = 0; i < burger.length; i++) {
                burger[i].addEventListener('click', function() {
                    for (var j = 0; j < menu.length; j++) {
                        menu[j].classList.toggle('hidden');
                    }
                });
            }
        }

        // close
        const close = document.querySelectorAll('.navbar-close');
        const backdrop = document.querySelectorAll('.navbar-backdrop');

        if (close.length) {
            for (var i = 0; i < close.length; i++) {
                close[i].addEventListener('click', function() {
                    for (var j = 0; j < menu.length; j++) {
                        menu[j].classList.toggle('hidden');
                    }
                });
            }
        }

        if (backdrop.length) {
            for (var i = 0; i < backdrop.length; i++) {
                backdrop[i].addEventListener('click', function() {
                    for (var j = 0; j < menu.length; j++) {
                        menu[j].classList.toggle('hidden');
                    }
                });
            }
        }
    });
</script>		