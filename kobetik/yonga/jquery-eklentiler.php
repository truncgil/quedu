<?php function formeeJS() {
js("kobetik/eklentiler/formee/formee.js") . _js();
linkCss("kobetik/eklentiler/formee/css/formee-style.css");
linkCss("kobetik/eklentiler/formee/css/formee-structure.css");
} ?>
<?php function fmHata($mesaj,$d="") { 
return sprintf('<div class="formee-msg-warning %s"><h1>%s</h1></div>',$d,$mesaj);
 } ?>
<?php function fmUyari($mesaj,$d="") { 
return sprintf('<div class="formee-msg-error %s"><h1>%s</h1></div>',$d,$mesaj);
 } ?>
<?php function fmBilgi($mesaj,$d="") { 
return sprintf('<div class="formee-msg-info %s"><h1>%s</h1></div>',$d,$mesaj);
} ?>
<?php function fmTamam($mesaj,$d="") { 
return sprintf('<div class="formee-msg-success %s"><h1>%s</h1></div>',$d,$mesaj);
} ?>
<?php function tableSorter() {
js("kobetik/eklentiler/tablesorter/jquery.tablesorter.min.js") . _js();
linkCss("kobetik/eklentiler/tablesorter/style.css");
} ?>
<?php function jOta($secici, $adres){ ?>
	<script>
	$(function() {
		var cache = {},
			lastXhr;
		var accentMap = {
			"â": "a",
			"i" : "Ý"
		};
		var normalize = function( term ) {
			var ret = "";
			for ( var i = 0; i < term.length; i++ ) {
				ret += accentMap[ term.charAt(i) ] || term.charAt(i);
			}
			return ret;
		};
		$( "<?php echo $secici ?>" ).autocomplete({
			minLength: 1,
			source: function( request, response ) {
				var term = request.term;
				if ( term in cache ) {
					response( $.grep( names, function( value ) {
					value = value.label || value.value || value;
					return matcher.test( value ) || matcher.test( normalize( value ) );
				}) );
				}

				lastXhr = $.getJSON( "<?php echo $adres ?>", request, function( data, status, xhr ) {
					cache[ term ] = data;
					if ( xhr === lastXhr ) {
						response( data );
					}
				});
			}
		});
	});
	</script>
<?php } ?>
<?php function JpopUp($en=640,$boy=480,$fAd="JpopUp") { ?>
<script type="text/javascript">
function <?php echo $fAd ?>(adres) {
window.open(adres,
"JpopUp", "menubar=0,resizable=false,scrollbars=1,width=<?php echo $en ?>,height=<?php echo $boy ?>");
}
</script>
<?php } ?>
<?php function jOtaSelect($secici){ ?>
	<style>
	.ui-button { margin-left: -1px; }
	.ui-button-icon-only .ui-button-text { padding: 0.35em; } 
	.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; }
	</style>
	<script>
	(function( $ ) {
		$.widget( "ui.combobox", {
			_create: function() {
				var self = this,
					select = this.element.hide(),
					selected = select.children( ":selected" ),
					value = selected.val() ? selected.text() : "";
				var input = $( "<input>" )
					.insertAfter( select )
					.val( value )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: function( request, response ) {
							var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
							response( select.children( "option" ).map(function() {
								var text = $( this ).text();
								if ( this.value && ( !request.term || matcher.test(text) ) )
									return {
										label: text.replace(
											new RegExp(
												"(?![^&;]+;)(?!<[^<>]*)(" +
												$.ui.autocomplete.escapeRegex(request.term) +
												")(?![^<>]*>)(?![^&;]+;)", "gi"
											), "<strong>$1</strong>" ),
										value: text,
										option: this
									};
							}) );
						},
						select: function( event, ui ) {
							ui.item.option.selected = true;
							self._trigger( "selected", event, {
								item: ui.item.option
							});
						},
						change: function( event, ui ) {
							if ( !ui.item ) {
								var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
									valid = false;
								select.children( "option" ).each(function() {
									if ( this.value.match( matcher ) ) {
										this.selected = valid = true;
										return false;
									}
								});
								if ( !valid ) {
									// remove invalid value, as it didn't match anything
									$( this ).val( "" );
									select.val( "" );
									return false;
								}
							}
						}
					})
					.addClass( "ui-widget ui-widget-content ui-corner-left" );

				input.data( "autocomplete" )._renderItem = function( ul, item ) {
					return $( "<li></li>" )
						.data( "item.autocomplete", item )
						.append( "<a>" + item.label + "</a>" )
						.appendTo( ul );
				};

				$( "<button>&nbsp;</button>" )
					.attr( "tabIndex", -1 )
					.attr( "title", "Show All Items" )
					.insertAfter( input )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "ui-corner-right ui-button-icon" )
					.click(function() {
						// close if already visible
						if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
							input.autocomplete( "close" );
							return;
						}

						// pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
						input.focus();
					});
			}
		});
	})( jQuery );

	$(function() {
		$( "<?php e($secici) ?>" ).combobox();
	});
	</script>
<?php } ?>