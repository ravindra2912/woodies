
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="{{ config('const.site_setting.fevicon') }}" rel="icon" >	
  <title>Admin | {{ config('const.site_setting.name') }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('admin_theme/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admin_theme/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('admin_theme/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Custom -->
  <link rel="stylesheet" href="{{ asset('admin_theme/dist/css/custom.css') }}">
  <!-- Ajax Jquery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!--Toastr -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

  <script>
    toastr.options = {
                        "closeButton": true,
                        "newestOnTop": true,
                        "positionClass": "toast-top-right"
                      };
  </script>
  
  <style>
	.m-hide{
		display:block;
	}
	.m-show{
		display:none;
	}
	@media only screen and (max-width: 600px) {
		.m-hide{
			display:none !important;
		}
		.m-show{
			display:block;
		}
		
	  }
  </style>
  
  <style>
			.content-wrapper {
				background-color: #f8f8f8;
			}
		  
			[class*=sidebar-dark-] {
				 background-color: #fff; 
			}
			
			[class*=sidebar-dark-] .sidebar a, [class*=sidebar-dark-] .sidebar a:hover {
				color: #000;
			}
			
			[class*=sidebar-dark-] .sidebar a, [class*=sidebar-dark-] .sidebar a:hover, [class*=sidebar-dark-] .nav-sidebar>.nav-item:hover>.nav-link, [class*=sidebar-dark-] .nav-sidebar>.nav-item>.nav-link:focus {
				color: #000;
			}
			
			[class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link {
				color: #000;
			}
			
			.nav-sidebar .nav-item>.nav-link.active, .nav-sidebar .nav-item>.nav-link:hover, .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link .active, .nav-sidebar>.nav-item.menu-open>.nav-link {
				background-color: #d7d6ff70 !important;
				color: #007bff !important;
				box-shadow: unset !important;
				    padding-left: 25px;
				transition: .5s;
			}
		  
			.nav-sidebar .nav-item>.nav-link i{
				    font-size: 21px !important;
					
			}
			.nav-sidebar .nav-item>.nav-link p{
				margin-left: 10px;
			}
			
			.user-panel {
				border-bottom: 3px solid gray !important;
			}
			
			
			.small-box {
				border-radius: 1.0rem;
			}
			.small-box>.small-box-footer {
				border-bottom-left-radius: 1.0rem;
				border-bottom-right-radius: 1.0rem;
			}
			
			/* pagination */
			.pagination {
				margin-top: 1rem;
				justify-content: flex-end;
			}
			.pagination .page-item{
				margin-right: 5px;
			}
			.pagination .page-item span, .pagination .page-item a {
				border-radius: 12px !important;
				border: 1px solid #007bff;
				font-weight: bold;
				color: #007bff;
			}
			.page-item.disabled .page-link {
				color: #007bff;
			}
			.page-item:last-child .page-link, .page-item.disabled .page-link {
				padding: 0.5rem 0.80rem;
				border: 1px solid #007bff;
				font-weight: bold;
			}
			
							
			.card{
				border-radius: 15px;
				
			}
			.table-card{
				overflow: overlay;
			}
			.table-card .card-body{
				padding: unset;
			}
			.table-card th, .table-card td {
				text-align:center;
				padding: 0.50rem;
			}
			
			.table-card th {
				padding: .75rem 0px;
			}
			
			.table-card tr {
				border-bottom: 1px solid #dee2e6;
			}
	
  </style>