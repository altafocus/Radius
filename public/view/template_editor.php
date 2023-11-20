<link rel="stylesheet" type="text/css" href="themes/editor/codemirror.css">
<link rel="stylesheet" type="text/css" href="themes/editor/monokai.css">


<div class="card card-success card-outline no-print">
  <div class="card-header">
  <div class="card-title">
    <select class="form-control" name="mode" id="btn_mode">
        <?php 

        if(!isset($_GET["mode"]) || empty($_GET["mode"])){ ?>
          <option value="vc">Username = Password</option>
          <option value="us">Username & Password</option>
        <?php }
        else{
            if($_GET["mode"] == "vc"){ ?>
              <option value="vc">Username = Password</option>
              <option value="us">Username & Password</option>
            <?php }

            if($_GET["mode"] == "us"){ ?>
              <option value="us">Username & Password</option>
              <option value="vc">Username = Password</option>
            <?php }
          }
        ?>
    </select>
  </div>
</div>

<div class="card-body p-0">
  <?php
    if(!isset($_POST["code"]) || empty($_POST["code"])){}
    else{
      if(!isset($_GET["mode"]) || empty($_GET["mode"])){
        $code = $_POST["code"];
        $file = fopen("themes/voucher.html", "w");
        fwrite($file, $code);
        fclose($file);
      }else{
        if($_GET["mode"] == "vc"){
          $code = $_POST["code"];
          $file = fopen("themes/voucher.html", "w");
          fwrite($file, $code);
          fclose($file);
        }
        if($_GET["mode"] == "us"){
          $code = $_POST["code"];
          $file = fopen("themes/member.html", "w");
          fwrite($file, $code);
          fclose($file);
        }
      }
    }
  ?>
  <form action="" method="POST">
    <textarea name="code" id="codeMirrorDemo" class="p-3">
      <?php
        if(!isset($_GET["mode"]) || empty($_GET["mode"])){
          $data = file_get_contents("themes/voucher.html");
          echo $data;
        }else{
          switch($_GET["mode"]){
            case "vc":
              $data = file_get_contents("themes/voucher.html");
              echo $data;
            break;
            case "us":
              $data = file_get_contents("themes/member.html");
              echo $data;
            break;
            default:
              $data = file_get_contents("themes/voucher.html");
              echo $data;
          }
        }
      ?>
    </textarea>
    <button class="btn btn-success m-2">Save Code</button>
    <button id="btn_preview" type="button" class="btn btn-primary m-2">Preview</button>
  </form>
</div>
</div>

<script type="text/javascript" src="themes/editor/codemirror.js"></script>
<script type="text/javascript" src="themes/editor/css.js"></script>
<script type="text/javascript" src="themes/editor/htmlmixed.js"></script>
<script type="text/javascript" src="themes/editor/xml.js"></script>
<script type="text/javascript" src="themes/editor/summernote-bs4.min.js"></script>
<script>
  $(function () {
    // Summernote
    $('#summernote').summernote()

    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
      mode: "htmlmixed",
      theme: "monokai"
    });
  });
  $(document).ready(function(){
    $("#btn_preview").click(function(){
      var mode = $("#btn_mode").val();
      window.open("view/template_preview.php?mode=" + mode);
    });
    $("#btn_mode").change(function(){
      window.location.href = "?view=template_editor&mode=" + this.value;
    });
  });
</script>