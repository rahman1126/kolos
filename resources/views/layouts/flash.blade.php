@if(Session::has('err'))
    <script type="text/javascript">
        $( document ).ready(function() {
            $.notifyDefaults({
            	type: 'danger',
            	allow_dismiss: false,
                placement: {
            		from: "top",
            		align: "center"
            	},
            });
            $.notify('{{ Session::get('err') }}');
        });
	</script>
@endif
@if(Session::has('msg'))
	<script type="text/javascript">
        $( document ).ready(function() {
            $.notifyDefaults({
            	type: 'info',
            	allow_dismiss: false,
                placement: {
            		from: "top",
            		align: "center"
            	},
            });
            $.notify('{{ Session::get('msg') }}');
        });
	</script>
@endif
