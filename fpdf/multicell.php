<?php


 class PDF extends FPDF
    {
        var $widths;
        var $aligns;
        var $mysqli;

		function setConnection($mysqli){
			$this->mysqli=$mysqli;
		}

        function SetWidths($w)
        {
          //Set the array of column widths
          $this->widths=$w;
        }

        function SetAligns($a)
        {
          //Set the array of column alignments
          $this->aligns=$a;
        }

        function Row($data)
        {
          //Calculate the height of the row
          $nb=0;
          for($i=0;$i< count($data);$i++)
              $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
          $h=0.5*$nb;
          //Issue a page break first if needed
          $this->CheckPageBreak($h);
          //Draw the cells of the row
          for($i=0;$i< count($data);$i++)
          {
              $w=$this->widths[$i];
              $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
              //Save the current position
              $x=$this->GetX();
              $y=$this->GetY();
              //Draw the border
              $this->Rect($x,$y,$w,$h);
              //Print the text
              $this->MultiCell($w,0.4,$data[$i],0, $this->aligns[$i]);
              //Put the position to the right of the cell
              $this->SetXY($x+$w,$y);
          }
          //Go to the next line
          $this->Ln($h);
        }

        function CheckPageBreak($h)
        {
          //If the height h would cause an overflow, add a new page immediately
          if($this->GetY()+$h>$this->PageBreakTrigger)
              $this->AddPage($this->CurOrientation);
        }

        function NbLines($w,$txt)
        {
          //Computes the number of lines a MultiCell of width w will take
          $cw=&$this->CurrentFont['cw'];
          if($w==0)
              $w=$this->w-$this->rMargin-$this->x;
          $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
          $s=str_replace("\r",'',$txt);
          $nb=strlen($s);
          if($nb>0 and $s[$nb-1]=="\n")
              $nb--;
          $sep=-1;
          $i=0;
          $j=0;
          $l=0;
          $nl=1;
          while($i<$nb)
          {
              $c=$s[$i];
              if($c=="\n")
              {
                  $i++;
                  $sep=-1;
                  $j=$i;
                  $l=0;
                  $nl++;
                  continue;
              }
              if($c==' ')
                  $sep=$i;
              $l+=$cw[$c];
              if($l>$wmax)
              {
                  if($sep==-1)
                  {
                      if($i==$j)
                          $i++;
                  }
                  else
                      $i=$sep+1;
                  $sep=-1;
                  $j=$i;
                  $l=0;
                  $nl++;
              }
              else
                  $i++;
          }
          return $nl;
        }
        function Header()
        {
			
			$sql_pdf = ("SELECT nom_endereco, nom_numero, nom_complemento, nom_cidade, nom_estado, num_cep FROM gab_vereador");
			$results = $this->mysqli->query($sql_pdf);
			$r=$results->fetch_object();
			
            if ($results->num_rows){
				$this->SetFont("Arial","B",25);
				$this->Cell(0,0.6,"Câmara Municipal de ".$r->nom_cidade,0,1,'C');		
				$this->Ln(0.3);
				$this->SetFont("Arial","B",9);
                $this->Cell(0,0.6, $r->nom_endereco.", ".$r->nom_numero." - ".$r->nom_complemento." - ".$r->nom_cidade." / ".$r->nom_estado." - CEP:".$r->num_cep,0,1,'C');
                $this->Ln(0.5);
			}
			else{
				$this->Ln(0.5);
			}	
            //$this->Image('logo.png',1,"0.5",2.5,2);
            //$this->Image('camara.jpg',18,"0.5",2,2);
            //$this->SetFont("Times","B",26);
            //$this->Cell(0,0.6,"Câmara Municipal de ",0,1,'C');
            //$this->Ln(0.3);
            //$this->SetFont("Arial","B",9);
            //$this->Cell(0,0.6,"Praça D. Pedro II, 1-50 - Centro - CEP 17015-230 - Fone: (14) 3235-0600 - Fax (14) 3235-0601",0,1,'C');
            //$this->Ln(0.5);
        }
    }
?>