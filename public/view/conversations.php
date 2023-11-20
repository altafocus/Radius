<div class="row">
	<div class="col-md-6">
		<button id="btn_signin" onclick="login()" class="btn btn-danger btn-block mb-4" style="display:none">Sign In With Google</button>
		<div id="conversations" class="card card-success card-outline direct-chat direct-chat-success" style="display: none;">
			<div class="card-header">
				<h3 class="card-title">Public Conversations</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse">
						<i class="fas fa-minus"></i>
					</button>
					<button type="button" class="btn btn-tool" data-card-widget="#" onclick="logout()">
						<i class="fas fa-times"></i>
					</button>
				</div>
			</div>

			<div class="card-body" id="card_body">
				<div class="direct-chat-messages" id="message" style="min-height: 70vh;"></div>
			</div>

			<div class="card-footer">
				<div class="input-group">
					<input type="text" id="text" placeholder="Type Message ..." class="form-control" autocomplete="off">
					<span class="input-group-append">
						<a href="#" class="btn btn-success" id="btn_send">Send</a>
					</span>
				</div>
			</div>

		</div>
	</div>

	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Joined Users</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse">
						<i class="fas fa-minus"></i>
					</button>
					<button type="button" class="btn btn-tool" data-card-widget="remove">
						<i class="fas fa-times"></i>
					</button>
				</div>
			</div>

			<div class="card-body p-0">
					<ul class="products-list product-list-in-card pl-2 pr-2" id="user_list"></ul>
				</div>

				<div class="card-footer text-center">
					<a href="javascript:void(0)" class="uppercase">View All Users</a>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		var _0x57f255=_0x1269;function _0x1269(_0xb9608c,_0xf1bc0f){var _0x467016=_0x4670();return _0x1269=function(_0x126932,_0x152cad){_0x126932=_0x126932-0x14a;var _0x337157=_0x467016[_0x126932];return _0x337157;},_0x1269(_0xb9608c,_0xf1bc0f);}(function(_0xd57cb8,_0x21f136){var _0x5b5e86=_0x1269,_0x34e6e8=_0xd57cb8();while(!![]){try{var _0x1be9fd=-parseInt(_0x5b5e86(0x166))/0x1+-parseInt(_0x5b5e86(0x15d))/0x2+parseInt(_0x5b5e86(0x159))/0x3+parseInt(_0x5b5e86(0x180))/0x4*(-parseInt(_0x5b5e86(0x17a))/0x5)+-parseInt(_0x5b5e86(0x183))/0x6*(parseInt(_0x5b5e86(0x177))/0x7)+parseInt(_0x5b5e86(0x14b))/0x8+parseInt(_0x5b5e86(0x174))/0x9;if(_0x1be9fd===_0x21f136)break;else _0x34e6e8['push'](_0x34e6e8['shift']());}catch(_0x1d3905){_0x34e6e8['push'](_0x34e6e8['shift']());}}}(_0x4670,0x5c59e));var db=firebase[_0x57f255(0x150)](),userdata;function _0x4670(){var _0x57e0b6=['GoogleAuthProvider','475737AgNNaC','#conversations','conversations','getElementById','text','signOut','\x22\x20alt=\x22message\x20user\x20image\x22>\x0a\x09\x09\x09\x09\x09\x09\x09\x09<div\x20class=\x22direct-chat-text\x22>\x0a\x09\x09\x09\x09\x09\x09\x09\x09','scrollTop','toLocaleString','#user_list','get','collection','\x22\x20alt=\x22Product\x20Image\x22\x20class=\x22img-size-50\x22>\x0a\x09\x09\x09\x09\x09\x09\x09</div>\x0a\x09\x09\x09\x09\x09\x09\x09<div\x20class=\x22product-info\x22>\x0a\x09\x09\x09\x09\x09\x09\x09<a\x20href=\x22javascript:void(0)\x22\x20class=\x22product-title\x22>\x0a\x09\x09\x09\x09\x09\x09\x09\x09','orderBy','9707157ReVsql','</span>\x0a\x09\x09\x09\x09\x09\x09\x09\x09<span\x20class=\x22direct-chat-timestamp\x20float-right\x22>','displayName','3615479qCRgPK','hide','auth','30XzWwsH','then','photoURL','</span>\x0a\x09\x09\x09\x09\x09\x09\x09\x09</div>\x0a\x09\x09\x09\x09\x09\x09\x09\x09<img\x20class=\x22direct-chat-img\x22\x20src=\x22','uid','data','78404UbkBml','click','en-ID','6FoBQPl','add','log','308544tUOAfT','\x0a\x09\x09\x09\x09\x09\x09\x09\x09</div>\x0a\x09\x09\x09\x09\x09\x09\x09\x09</div>\x0a\x09\x09\x09\x09\x09\x09\x09\x09','</span>\x0a\x09\x09\x09\x09\x09\x09\x09\x09<span\x20class=\x22direct-chat-timestamp\x20float-left\x22>','html','#text','firestore','#btn_signin','#message','\x0a\x09\x09\x09\x09\x09\x09\x09\x09<span\x20class=\x22badge\x20badge-warning\x20float-right\x22>Online</span>\x0a\x09\x09\x09\x09\x09\x09\x09</a>\x0a\x09\x09\x09\x09\x09\x09\x09\x09<span\x20class=\x22product-description\x22>\x0a\x09\x09\x09\x09\x09\x09\x09\x09\x09','change','onAuthStateChanged','forEach','users','timestamp','1411476ryfAtk','message','ready','val','199046YMApRl','show','append','\x0a\x09\x09\x09\x09\x09\x09\x09\x09</span>\x0a\x09\x09\x09\x09\x09\x09\x09</div>\x0a\x09\x09\x09\x09\x09\x09</li>\x0a\x09\x09\x09\x09\x09','signInWithRedirect','UTC','email','onSnapshot'];_0x4670=function(){return _0x57e0b6;};return _0x4670();}let found=0x0;firebase['auth']()[_0x57f255(0x155)](function(_0x1e4f10){var _0x536f0a=_0x57f255;_0x1e4f10?(userdata=_0x1e4f10,$('#conversations')[_0x536f0a(0x15e)](),$(_0x536f0a(0x151))[_0x536f0a(0x178)](),db[_0x536f0a(0x171)](_0x536f0a(0x168))[_0x536f0a(0x173)](_0x536f0a(0x158))[_0x536f0a(0x164)](function(_0x56b596){var _0x42f164=_0x536f0a;$('#message')[_0x42f164(0x14e)](''),_0x56b596['forEach'](function(_0x3104cf){var _0x3693b8=_0x42f164;_0x3104cf[_0x3693b8(0x17f)]()[_0x3693b8(0x17e)]==userdata['uid']?$(_0x3693b8(0x152))[_0x3693b8(0x15f)]('\x0a\x09\x09\x09\x09\x09\x09\x09\x09<div\x20class=\x22direct-chat-msg\x20right\x22>\x0a\x09\x09\x09\x09\x09\x09\x09\x09<div\x20class=\x22direct-chat-infos\x20clearfix\x22>\x0a\x09\x09\x09\x09\x09\x09\x09\x09<span\x20class=\x22direct-chat-name\x20float-right\x22>'+_0x3104cf[_0x3693b8(0x17f)]()[_0x3693b8(0x176)]+_0x3693b8(0x14d)+_0x3104cf[_0x3693b8(0x17f)]()['timestamp']+_0x3693b8(0x17d)+_0x3104cf[_0x3693b8(0x17f)]()['photoURL']+_0x3693b8(0x16c)+_0x3104cf['data']()['text']+_0x3693b8(0x14c)):$(_0x3693b8(0x152))['append']('\x0a\x09\x09\x09\x09\x09\x09\x09\x09<div\x20class=\x22direct-chat-msg\x22>\x0a\x09\x09\x09\x09\x09\x09\x09\x09<div\x20class=\x22direct-chat-infos\x20clearfix\x22>\x0a\x09\x09\x09\x09\x09\x09\x09\x09<span\x20class=\x22direct-chat-name\x20float-left\x22>'+_0x3104cf[_0x3693b8(0x17f)]()[_0x3693b8(0x176)]+_0x3693b8(0x175)+_0x3104cf['data']()[_0x3693b8(0x158)]+_0x3693b8(0x17d)+_0x3104cf['data']()['photoURL']+_0x3693b8(0x16c)+_0x3104cf[_0x3693b8(0x17f)]()[_0x3693b8(0x16a)]+_0x3693b8(0x14c));});var _0x4c9397=document[_0x42f164(0x169)](_0x42f164(0x15a));_0x4c9397[_0x42f164(0x16d)]=_0x4c9397['scrollHeight'];}),db[_0x536f0a(0x171)]('users')[_0x536f0a(0x170)]()['then'](function(_0x5ca62c){var _0x2a45ce=_0x536f0a;_0x5ca62c['forEach'](function(_0x4e1b3f){var _0x2cac08=_0x1269;console[_0x2cac08(0x14a)](_0x4e1b3f[_0x2cac08(0x17f)]()[_0x2cac08(0x17e)]),userdata['uid']==_0x4e1b3f[_0x2cac08(0x17f)]()['uid']&&found++;}),found==0x0&&db[_0x2a45ce(0x171)](_0x2a45ce(0x157))[_0x2a45ce(0x184)]({'uid':userdata[_0x2a45ce(0x17e)],'email':userdata[_0x2a45ce(0x163)],'displayName':userdata[_0x2a45ce(0x176)],'photoURL':userdata[_0x2a45ce(0x17c)]});})):($(_0x536f0a(0x167))[_0x536f0a(0x178)](),$('#btn_signin')[_0x536f0a(0x15e)]());});function login(){var _0x49e066=_0x57f255,_0x25c2c7=new firebase['auth'][(_0x49e066(0x165))]();firebase[_0x49e066(0x179)]()[_0x49e066(0x161)](_0x25c2c7);}function logout(){var _0x372af2=_0x57f255;firebase['auth']()[_0x372af2(0x16b)]()[_0x372af2(0x17b)](function(){var _0x4591f2=_0x372af2;$(_0x4591f2(0x167))[_0x4591f2(0x178)](),$('#btn_signin')[_0x4591f2(0x15e)]();});}db[_0x57f255(0x171)]('users')[_0x57f255(0x164)](function(_0x30fa41){var _0x172241=_0x57f255;$(_0x172241(0x16f))['html'](''),_0x30fa41[_0x172241(0x156)](function(_0x18262b){var _0x377a8b=_0x172241;$(_0x377a8b(0x16f))[_0x377a8b(0x15f)]('\x0a\x09\x09\x09\x09\x09\x09<li\x20class=\x22item\x22>\x0a\x09\x09\x09\x09\x09\x09\x09<div\x20class=\x22product-img\x22>\x0a\x09\x09\x09\x09\x09\x09\x09\x09<img\x20src=\x22'+_0x18262b['data']()[_0x377a8b(0x17c)]+_0x377a8b(0x172)+_0x18262b['data']()[_0x377a8b(0x176)]+_0x377a8b(0x153)+_0x18262b[_0x377a8b(0x17f)]()[_0x377a8b(0x163)]+_0x377a8b(0x160));});});function send_message(){var _0x541c63=_0x57f255,_0x3bfd4e=$(_0x541c63(0x14f))[_0x541c63(0x15c)]();if(_0x3bfd4e==''){}else db[_0x541c63(0x171)]('conversations')['add']({'uid':userdata['uid'],'email':userdata['email'],'displayName':userdata[_0x541c63(0x176)],'photoURL':userdata[_0x541c63(0x17c)],'text':_0x3bfd4e,'timestamp':new Date()[_0x541c63(0x16e)](_0x541c63(0x182),{'timeZone':_0x541c63(0x162)})})[_0x541c63(0x17b)](function(){var _0x39603e=_0x541c63;$(_0x39603e(0x14f))['val']('');});}$(document)[_0x57f255(0x15b)](function(){var _0x213755=_0x57f255;$('#btn_signin')['click'](function(){login();}),$('#btn_send')[_0x213755(0x181)](function(){send_message();}),$(_0x213755(0x14f))[_0x213755(0x154)](function(){send_message();});});

	</script>

