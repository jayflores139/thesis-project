<!DOCTYPE html>
<html>
<head>
	<title>BORING STUFF</title>
	<link rel="icon" href="notepad.jpg">
	<script src="js/jquery.js"></script>
	<style type="text/css">
		* {
			font-family: arial;
		}
		#colorCOn{
			color:#888;
			float:left;
			width:30%;
			padding:10px 0px 10px 10px;
		}
		#rightCon {
			float:right;
			width:65%;
			padding:10px 10px 10px 30px;
		}
		#rightCon textarea {
			width:98%;
			height:600px;
			padding:10px;
			outline:none;
			resize: none;
			border:1px solid #f1f1f1;
		}
		#colorCOn div {
			border:0;
			padding:3px;
			border-radius: 3px;
		}

		label select {
			border:0;
			padding:5px 10px;
			background-color: #F3F3F3;
			outline: none;
			border-radius: 3px;
			color:#888;
		}
		
		textarea {
		    -moz-box-shadow:3px 3px 5px 6px #ccc;
            -webkit-box-shadow: 3px 3px 5px 6px #ccc;
            box-shadow:3px 3px 5px 6px #ccc;
            background:#f9fcfc;
		}
		
		.ripple {
          background-position: center;
          transition: background 0.8s;
        }
        .ripple:hover {
          background: #47a7f5 radial-gradient(circle, transparent 1%, #ede9e8 1%) center/15000%;
        }
        .ripple:active {
          background-color: #6eb9f7;
          background-size: 100%;
          transition: background 0s;
        }
        
        /* Button style */
        label button {
          border: none;
          border-radius: 2px;
          width:100px;
          outline:none;
          padding:15px 0;
        }
	</style>
</head>
<body>

	<div> 
		<div id="colorCOn">
			<table>
				<tr>
					<td>
						<label>
							<button style="background-color:#F3F3F3" class="ripple textColor" id="#f70f0f">
								<span style="color:#111">RED </span>
							</button>
						</label>
					</td>
					<td>
						<label>
							<button style="background-color:#F3F3F3" class="ripple textColor" id="#4CAF50">
								<span style="color:#111">GREEN  </span>
							</button>
						</label>
					</td>
					<td>
						<label>
							<button style="background-color:#F3F3F3" class="ripple textColor" id="#3547ab">
								<span style="color:#111">BLUE </span>
							</button>
						</label>
					</td>
					<td>
						<label>
							<button style="background-color:#F3F3F3" class="ripple textColor" id="#eab72c">
								<span style="color:#111">YELLOW</span>
							</button>
						</label>
					</td>
				</tr>
				<tr>
				    <td>
				        <label>
				            <button style="background-color:#F3F3F3" class="ripple textColor" id="#111">
								<span style="color:#111">BLACK</span>
							</button>
				        </label>
				    </td>
				    <td>
				        <label>
				            <button style="background-color:#F3F3F3" class="ripple textColor" id="#24edcb">
								<span style="color:#111">TEAL</span>
							</button>
				        </label>
				    </td>
				    <td>
				        <label>
				            <button style="background-color:#F3F3F3" class="ripple textColor" id="#f49842">
								<span style="color:#111">ORANGE</span>
							</button>
				        </label>
				    </td>
				    <td>
				        <label>
				            <button style="background-color:#F3F3F3" class="ripple textColor" id="#ed25c5">
								<span style="color:#111">PURPLE</span>
							</button>
				        </label>
				    </td>
				</tr>
			</table> <br>

			<table>
				<tr>
					<td>
						<label>
							<div style="background-color:#F3F3F3">
								<input type="radio" name="fontstyle" class="fontQly" value="bold">
								<span style="font-weight: bold;">Bold</span>
							</div>
						</label>
					</td>
					<td>
						<label>
							<div style="background-color:#F3F3F3">
								<input type="radio" name="fontstyle" class="fontQly" value="normal">
								<span style="font-weight: normal;">Normal</span>
							</div>
						</label>
					</td>
					<td>
						<label>
							<div style="background-color:#F3F3F3">
								<input type="radio" name="fontstyle" class="fontQly" value="italic">
								<span style="font-style: italic;">Italic</span>
							</div>
						</label>
					</td>
				</tr>
			</table> <br>

			<table>
				<tr>
					<td>
						<label>				
							<select class="fontSize">
								<?php 	 
									for ($i=11; $i <= 100; $i++) { ?>
								<option value="<?php echo $i ?>px"><?php echo $i ?></option>
								<?php		
									}
								?>
							</select> pt
						</label>
					</td>
					<td>
						<label style="margin-left: 10px">
							<select class="fontFamily">
								<option value="arial">Arial</option>
								<option value="verdana">Verdana</option>
								<option value="Times New Roman">Times New Roman</option>
								<option value="Serif">Serif</option>
							</select>
						</label>
					</td>
				</tr>
			</table> <br>

			<table>
				<tr>
					<td>
						<label>
							<div style="background-color:#F3F3F3">
								<input type="radio" name="trans" class="trans" value="none"> None
							</div>
						</label>
					</td>
					<td>
						<label>
							<div style="background-color:#F3F3F3">
								<input type="radio" name="trans" class="trans" value="uppercase"> Uppercase
							</div>
						</label>
					</td>
					<td>
						<label>
							<div style="background-color:#F3F3F3">
								<input type="radio" name="trans" class="trans" value="lowercase"> Lowercase
							</div>
						</label>
					</td>
				</tr>
			</table> <br>
			<button class="Clearr" style="background-color:#fff;border:1px solid #888;color:#888;font-size:17px;padding:6px;border-radius:3px;">About</button>
		</div>

		<div id="rightCon">
			<textarea class="textPage" placeholder="Start typing here..."></textarea>
		</div>
	</div>

</body>
</html>

<script>
	$(document).ready(function(){

		$(".textColor").click(function(){
			var color = $(this).attr("id");
			$(".textPage").css("color", color);
		});


		$(".fontQly").click(function(){
			var qly = $(this).val();
			if (qly == "italic") {
				$(".textPage").css("fontStyle", qly);
			} else if (qly == "bold") {
				$(".textPage").css("fontWeight", "bold");
			} else if (qly == "normal") {
				$(".textPage").css("fontWeight", "normal")
				$(".textPage").css("fontStyle", "inherit");
			}
		});


		$(".fontSize").change(function(){
			var fonntSize = $(this).val();
			$(".textPage").css("fontSize", fonntSize);
		});


		$(".fontFamily").change(function(){
			var fontFamily = $(this).val();
			$(".textPage").css("fontFamily", fontFamily);
		});


		$(".trans").click(function(){
			var trans = $(this).val();
			$(".textPage").css("textTransform", trans);
		});


		$(".Clearr").click(function(){
			window.open("about.php");
		});


	});
</script>
