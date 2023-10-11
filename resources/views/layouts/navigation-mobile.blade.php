<nav class="navbar-menu relative z-50 hidden">
    <div class="navbar-backdrop fixed inset-0 bg-gray-800 opacity-25"></div>
    <div class="fixed top-0 left-0 bottom-0 flex flex-col w-5/6 max-w-sm py-6 px-6 dark:bg-[#202124] bg-[#d0d5d6] dark:text-white text-black border-r dark:border-r-[#4e5158] overflow-y-auto">
        <div class="flex flex-row items-center mb-8">
            <a class="mr-auto text-3xl font-bold leading-none" href="#">
                <div class="rounded-full mx-auto h-16 w-16 w- aspect-square overflow-hidden border-2 border-gsv-purple">
                    <img src="{{ asset('/images/JorisInfoA.jpg') }}" alt="Profielfoto" class="object-cover h-full aspect-square" />
                </div>
            </a>
            <x-navigation.mobile.user-show />
            <button class="navbar-close">
                <svg class="h-6 w-6 text-gray-400 cursor-pointer hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div>
        <ul class="pt-6 mt-6 rounded-2xl ml-3 mr-3 pb-6 text-left">
            <x-navigation.mobile.menu-item title="Forum" link="/"> 
                <svg fill="none" class="h-6 w-6 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 3C5.11765 3 3 4.64706 3 10C3 13.7383 4.0328 15.6692 7 16.4939V21L11.0124 16.9876C11.3301 16.996 11.6592 17 12 17C18.8824 17 21 15.3529 21 10C21 4.64706 18.8824 3 12 3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </x-navigation.mobile.menu-item> 
            <x-navigation.mobile.menu-item title="Jaarbundel" link="/jaarbundel"> 
                <svg fill="none" class="h-6 w-6 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2.75C11.3096 2.75 10.75 3.30964 10.75 4C10.75 4.69036 11.3096 5.25 12 5.25C12.6904 5.25 13.25 4.69036 13.25 4C13.25 3.30964 12.6904 2.75 12 2.75ZM9.25 4C9.25 2.48122 10.4812 1.25 12 1.25C13.5188 1.25 14.75 2.48122 14.75 4C14.75 5.51878 13.5188 6.75 12 6.75C10.4812 6.75 9.25 5.51878 9.25 4ZM16.9894 7.16382C18.4102 6.85936 19.75 7.94247 19.75 9.39553C19.75 10.3779 19.1214 11.2501 18.1894 11.5608L16.0141 12.2859C15.877 12.3316 15.795 12.3591 15.7342 12.3821C15.6957 12.3966 15.6795 12.4044 15.6756 12.4063C15.5935 12.4582 15.5488 12.5528 15.561 12.6491C15.562 12.6534 15.5663 12.6709 15.5795 12.7098C15.6004 12.7714 15.6313 12.8522 15.6832 12.987L16.93 16.2287C17.4901 17.6849 16.4152 19.25 14.8549 19.25C14.0571 19.25 13.3205 18.8225 12.9246 18.1298L12 16.5117L11.0754 18.1298C10.6795 18.8225 9.94287 19.25 9.14506 19.25C7.58484 19.25 6.50994 17.6849 7.07002 16.2287L8.31681 12.987C8.36869 12.8522 8.3996 12.7714 8.42051 12.7098C8.43373 12.6709 8.43803 12.6534 8.43901 12.6491C8.4512 12.5528 8.40652 12.4582 8.32443 12.4063C8.32052 12.4044 8.30434 12.3966 8.26583 12.3821C8.20501 12.3591 8.12301 12.3316 7.98592 12.2859L5.81062 11.5608C4.87863 11.2501 4.25 10.3779 4.25 9.39553C4.25 7.94247 5.58979 6.85936 7.0106 7.16382L8.90817 7.57044C9.01467 7.59326 9.06443 7.60392 9.11353 7.61407C11.0177 8.00795 12.9823 8.00795 14.8865 7.61407C14.9356 7.60392 14.9853 7.59326 15.0918 7.57044L16.9894 7.16382ZM18.25 9.39553C18.25 8.89743 17.7907 8.52615 17.3037 8.63052L15.4034 9.03773C15.3006 9.05975 15.2453 9.0716 15.1903 9.08298C13.0857 9.51831 10.9143 9.51831 8.80969 9.08298C8.7547 9.0716 8.69947 9.05977 8.59688 9.03779L6.69631 8.63052C6.20927 8.52615 5.75 8.89743 5.75 9.39553C5.75 9.73228 5.96549 10.0313 6.28497 10.1378L8.46026 10.8629C8.47839 10.8689 8.49661 10.8749 8.5149 10.881C8.72048 10.9491 8.93409 11.0199 9.1102 11.1286C9.69929 11.4922 10.0186 12.169 9.92485 12.8548C9.89681 13.0599 9.81566 13.2698 9.73756 13.4718C9.73061 13.4898 9.72369 13.5077 9.71683 13.5255L8.47004 16.7672C8.28784 17.2409 8.63751 17.75 9.14506 17.75C9.40459 17.75 9.64422 17.6109 9.77299 17.3856L11.3488 14.6279C11.4823 14.3942 11.7309 14.25 12 14.25C12.2691 14.25 12.5177 14.3942 12.6512 14.6279L14.227 17.3856C14.3558 17.6109 14.5954 17.75 14.8549 17.75C15.3625 17.75 15.7122 17.2409 15.53 16.7672L14.2832 13.5255C14.2763 13.5077 14.2694 13.4898 14.2624 13.4718C14.1843 13.2698 14.1032 13.0599 14.0751 12.8548C13.9814 12.169 14.3007 11.4922 14.8898 11.1286C15.0659 11.0199 15.2795 10.9491 15.4851 10.881C15.5034 10.8749 15.5216 10.8689 15.5397 10.8629L17.715 10.1378C18.0345 10.0313 18.25 9.73228 18.25 9.39553ZM5.21639 14.1631C5.40245 14.5332 5.25328 14.984 4.88321 15.1701C3.36229 15.9348 2.75 16.7949 2.75 17.5C2.75 18.2637 3.47401 19.2048 5.23671 19.998C6.929 20.7596 9.31951 21.25 12 21.25C14.6805 21.25 17.071 20.7596 18.7633 19.998C20.526 19.2048 21.25 18.2637 21.25 17.5C21.25 16.7949 20.6377 15.9348 19.1168 15.1701C18.7467 14.984 18.5975 14.5332 18.7836 14.1631C18.9697 13.793 19.4205 13.6439 19.7906 13.8299C21.4366 14.6575 22.75 15.9 22.75 17.5C22.75 19.2216 21.2354 20.5305 19.3788 21.3659C17.4518 22.2331 14.8424 22.75 12 22.75C9.15764 22.75 6.54815 22.2331 4.62116 21.3659C2.76457 20.5305 1.25 19.2216 1.25 17.5C1.25 15.9 2.5634 14.6575 4.20941 13.8299C4.57948 13.6439 5.03032 13.793 5.21639 14.1631Z" fill="currentColor"/>
                </svg>
            </x-navigation.mobile.menu-item> 
            <x-navigation.mobile.menu-item title="Foto's" link="https://www.dropbox.com/sh/35nn6690kcvk7wx/AACnG0OpTvw4I1WcvwUhOZYaa?dl=0"> 
                <svg fill="none" class="h-6 w-6 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 6C3 4.34315 4.34315 3 6 3H14C15.6569 3 17 4.34315 17 6V14C17 15.6569 15.6569 17 14 17H6C4.34315 17 3 15.6569 3 14V6Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M21 7V18C21 19.6569 19.6569 21 18 21H7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M3 12.375L6.66789 8.70711C7.05842 8.31658 7.69158 8.31658 8.08211 8.70711L10.875 11.5M10.875 11.5L13.2304 9.1446C13.6209 8.75408 14.2541 8.75408 14.6446 9.14461L17 11.5M10.875 11.5L12.8438 13.4688" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg> 
            </x-navigation.mobile.menu-item> 
            <x-navigation.mobile.menu-item title="Commissies" link="/commissies"> 
                <svg fill="none" class="h-6 w-6 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 9C2 7.89543 2.89543 7 4 7H20C21.1046 7 22 7.89543 22 9V20C22 21.1046 21.1046 22 20 22H4C2.89543 22 2 21.1046 2 20V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M16 7V4C16 2.89543 15.1046 2 14 2H10C8.89543 2 8 2.89543 8 4V7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M22 12H2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M7 12V14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M17 12V14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg> 
            </x-navigation.mobile.menu-item> 
            <x-navigation.mobile.menu-item title="Admin" link="/"> 
                <svg fill="none" class="h-6 w-6 mr-2" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 21C5 17.134 8.13401 14 12 14C15.866 14 19 17.134 19 21M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>    
            </x-navigation.mobile.menu-item> 
        </ul>
    </div>
        <div class="mt-auto mx-auto flex flex-col">
            <x-navigation.mobile.dark-toggle />
            <div class="pt-3">
                <form method="POST" action="{{ route('uitloggen') }}">
                    @csrf

                    <button type="submit" class="flex flex-row dark:text-white text-black ml-6 mt-2 hover:cursor-pointer hover:text-black/70 dark:hover:text-white/70">
                        <p class="text-xs my-auto mr-2 mx-auto">
                            Log uit
                        </p>
                        <svg class="h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 20H6C4.89543 20 4 19.1046 4 18L4 6C4 4.89543 4.89543 4 6 4H14M10 12H21M21 12L18 15M21 12L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>