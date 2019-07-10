        @include('admin.includes.header')
        <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                
                <ul class="nav side-menu">
                  <li><a href="{{ route('home') }}"><i class="fa fa-table"></i> Home</a></li>
                  <li><a href="{{ route('car') }}"><i class="fa fa-table"></i> Cars</a></li>
                <!--  <li><a href="{{ route('search_car') }}"><i class="fa fa-search"></i> Search</a> </li> -->
                 <li><a href="{{ route('mobile') }}"><i class="fa fa-search"></i> Mobile</a> </li> 

                  
                </ul>
              </div>

            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        @include('admin.includes.navigate')