	<script>
        const DEBUGMODE = <?=json_encode($ci->config->item('enable_profiler'))?>;
		const BASEURL = <?= json_encode(base_url()) ?>;
	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	<script src="{{base_url('public/js/jquery.js')}}"></script>
	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
	<script src="{{base_url('public/js/star.js?v=' . SITEVERSION)}}"></script>
	@isset($footer_includes)
		@foreach($footer_includes as $include)
		<?php echo $include ?>
		@endforeach
	@endisset	
	</body>
</html>