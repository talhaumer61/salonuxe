
        <script src="{{asset('dashboard/vendor/jquery/jquery.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/jquery-browser-mobile/jquery.browser.mobile.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/jquery-cookie/jquery.cookie.js')}}"></script>		
        <script src="{{asset('dashboard/master/style-switcher/style.switcher.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/popper/umd/popper.min.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/common/common.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/nanoscroller/nanoscroller.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/magnific-popup/jquery.magnific-popup.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/jquery-placeholder/jquery.placeholder.js')}}"></script>
		<!-- Specific Page Vendor -->
		
        <script src="{{asset('dashboard/vendor/jquery-ui/jquery-ui.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/jqueryui-touch-punch/jquery.ui.touch-punch.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/jquery-appear/jquery.appear.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/bootstrap-multiselect/js/bootstrap-multiselect.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/jquery.easy-pie-chart/jquery.easypiechart.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/flot/jquery.flot.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/flot.tooltip/jquery.flot.tooltip.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/flot/jquery.flot.pie.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/flot/jquery.flot.categories.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/flot/jquery.flot.resize.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/jquery-sparkline/jquery.sparkline.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/raphael/raphael.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/morris/morris.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/gauge/gauge.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/snap.svg/snap.svg.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/liquid-meter/liquid.meter.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/jqvmap/jquery.vmap.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/jqvmap/data/jquery.vmap.sampledata.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/jqvmap/maps/jquery.vmap.world.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/jqvmap/maps/continents/jquery.vmap.africa.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/jqvmap/maps/continents/jquery.vmap.asia.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/jqvmap/maps/continents/jquery.vmap.australia.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/jqvmap/maps/continents/jquery.vmap.europe.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/jqvmap/maps/continents/jquery.vmap.north-america.js')}}"></script>		
        <script src="{{asset('dashboard/vendor/jqvmap/maps/continents/jquery.vmap.south-america.js')}}"></script>
		<!-- Theme Base, Components and Settings -->
		
        <script src="{{asset('dashboard/js/theme.js')}}"></script>
		<!-- Theme Custom -->
		
        <script src="{{asset('dashboard/js/custom.js')}}"></script>
		<!-- Theme Initialization Files -->
		
        <script src="{{asset('dashboard/js/theme.init.js')}}"></script>
		<!-- Analytics to Track Preview Website -->
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		  ga('create', 'UA-42715764-8', 'auto');
		  ga('send', 'pageview');

          // Wait for the DOM to load
        document.addEventListener("DOMContentLoaded", function () {
            // Get the current URL path
            const currentPath = window.location.pathname;

            // Select all nav links
            const navLinks = document.querySelectorAll(".header-nav .nav-link");

            // Loop through each nav link
            navLinks.forEach(link => {
                // Check if the link's href matches the current path
                if (link.getAttribute("href") === currentPath) {
                    // Add 'active' class to the matching link
                    link.classList.add("active");

                    // Add 'active' class to its parent <li> (if necessary)
                    const parentLi = link.closest("li");
                    if (parentLi) {
                        parentLi.classList.add("active");
                    }

                    // If the link is inside a dropdown, open the dropdown menu
                    const dropdownParent = link.closest(".dropdown");
                    if (dropdownParent) {
                        dropdownParent.classList.add("active");
                    }
                }
            });
        });

		</script>
		{{-- Active tabs in profile page --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var activeTab = '{{ session("activeTab") }}';
                if (activeTab) {
                    var tab = document.querySelector(`.nav-link[href="#${activeTab}"]`);
                    if (tab) {
                        var bsTab = new bootstrap.Tab(tab);
                        bsTab.show();
                    }
                }
            });
        </script>
	</body>
</html>