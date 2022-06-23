<div class="min-h-screen relative bg-white overflow-hidden">
  
  <div class="max-w-7xl mx-auto">
    
    <div class="md:min-h-screen relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
      <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-white transform translate-x-1/2" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
        <polygon points="50,0 100,0 50,100 0,100" />
      </svg>

      <div>
        <div class="relative pt-6 px-4 sm:px-6 lg:px-8">
          
        </div>

      </div>

      <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
        <div class="sm:text-center lg:text-left">
          <p class="my-3 sm:mt-5 sm:max-w-xl sm:mx-auto md:mt-5 sm:text-base md:text-xl lg:mx-0">Politeknik Negeri Batam, Indonesia  - 5 October 2022</p>

          <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-4xl md:text-5xl">
            <span class="block xl:inline">THE 5TH INTERNATIONAL</span>
            <span class="block text-indigo-600 xl:inline">CONFERENCE ON APPLIED ENGINEERING (ICAE)</span>
          </h1>

          
          <p class="my-3 text-2xl uppercase text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-3xl lg:mx-0">Responsing the Metaverse Era for Future Applied Technology.</p>
          
          

          <div
              class="items-center justify-center"
              x-data="beer()"
              x-init="start()"
            >
              <div class="">
                <div
                  class="text-xl text-center text-white  flex w-full"
                >
                  <div class="w-24 mx-1 p-2 bg-gray-500 rounded-lg">
                    <div x-text="days">00</div>
                    <div >
                      Day
                    </div>
                  </div>
                  <div class="w-24 mx-1 p-2 bg-gray-500 rounded-lg">
                    <div x-text="hours">00</div>
                    <div >
                      Hour
                    </div>
                  </div>
                  <div class="w-24 mx-1 p-2 bg-gray-500 rounded-lg">
                    <div x-text="minutes">
                      00
                    </div>
                    <div >
                      Minute
                    </div>
                  </div>
                  <div class="w-24 mx-1 p-2 bg-gray-500 rounded-lg">
                    <div x-text="seconds">
                      00
                    </div>
                    <div >
                      Second
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
            <div class="rounded-md shadow">
              <a href="https://ieeexplore.ieee.org/xpl/conhome/8556142/proceeding" target="_blank" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 md:py-4 md:text-sm md:px-10">ICAE Proceeding 2018 </a>
            </div>
            <div class="mt-3 sm:mt-0 sm:ml-3">
              <a href="https://ieeexplore.ieee.org/xpl/conhome/9211296/proceeding" target="_blank" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 md:py-4 md:text-sm md:px-10">ICAE Proceeding 2019 </a>
            </div>
            <div class="mt-3 sm:mt-0 sm:ml-3">
              <a href="https://ieeexplore.ieee.org/xpl/conhome/9350316/proceeding" target="_blank" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 md:py-4 md:text-sm md:px-10">ICAE Proceeding 2020 </a>
            </div>
          </div>
          
          <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
            <div class="rounded-md shadow">
              <a href="https://ieeexplore.ieee.org/xpl/conhome/9350316/proceeding" target="_blank" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 md:py-4 md:text-sm md:px-10">ICAE Proceeding 2021 </a>
            </div>
          </div>
        </div>
        
      </main>
    </div>
  </div>
  <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
    <img class="h-auto w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="img/new_banner.png" alt="">
  </div>

  
  
</div>

@push('addon-scripts')
  <script>
      function beer() {
        
        return {
          seconds: "00",
          minutes: "00",
          hours: "00",
          days: "00",
          distance: 0,
          countdown: null,
          beerTime: new Date("Oct 5, 2022 00:00:00").getTime(),
          now: new Date().getTime(),
          
          start: function () {
            this.countdown = setInterval(() => {
              // Calculate time
              this.now = new Date().getTime();
              
              this.distance = this.beerTime - this.now;
              // Set Times
              this.days = this.padNum(
                Math.floor(this.distance / (1000 * 60 * 60 * 24))
              );
              this.hours = this.padNum(
                Math.floor(
                  (this.distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
                )
              );
              this.minutes = this.padNum(
                Math.floor((this.distance % (1000 * 60 * 60)) / (1000 * 60))
              );
              this.seconds = this.padNum(
                Math.floor((this.distance % (1000 * 60)) / 1000)
              );
              // Stop
              if (this.distance < 0) {
                clearInterval(this.countdown);
                this.days = "00";
                this.hours = "00";
                this.minutes = "00";
                this.seconds = "00";
              }
            }, 100);
          },
          padNum: function (num) {
            var zero = "";
            for (var i = 0; i < 2; i++) {
              zero += "0";
            }
            return (zero + num).slice(-3);
          },
        };
      }
    </script>
@endpush