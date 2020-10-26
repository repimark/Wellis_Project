<?php
  include('connect.php');
		$sql_dolgozok="SELECT dolgozok.d_id AS 'id', dolgozok.d_nev AS 'nev', pozicio.p_elnevezes AS 'pozi', allapot.a_elnevezes AS 'állapot', dolgozok.a_id AS 'állapot_id', terulet.t_elnevezes AS 'terület', dolgozok.p_id AS 'pozi_id', dolgozok.t_id AS 'ter_id' FROM dolgozok, pozicio, allapot, terulet WHERE dolgozok.a_id = allapot.a_id AND dolgozok.p_id = pozicio.p_id AND dolgozok.t_id = terulet.t_id";
		
		$result = $conn->query($sql_dolgozok);
		
		$conn->set_charset('utf-8');
		
		$db = 0;
		
		if ($result->num_rows > 0) {
  			// output data of each row
  			
  			while($row = $result->fetch_assoc()) { 
          if ($row['állapot_id'] == '2') {
            ?>
            <tr class="table-danger" id="<?php echo $row['id'];?>">
            <td id="d_nev"><?php echo $row["nev"]; ?></td>
            <td id="d_ter" data-id="<?php echo $row['ter_id']; ?>"><?php echo $row["terület"]; ?></td>
            <td id="d_pozi" data-id="<?php echo $row['pozi_id']; ?>"><?php echo $row["pozi"]; ?></td>
            <td id="d_allapot" data-id="<?php echo $row['állapot_id']; ?>"><?php echo $row["állapot"]; ?></td>
            <td>
              <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal" id="modalButton" data-whatever="<?php echo $row['nev'];?>" data-id="<?php echo $row['id'];?>" data-terulet="<?php echo $row['ter_id'];?>" data-pozicio="<?php echo $row['pozi_id'] ?>" data-allapot="<?php echo $row['állapot_id']; ?>">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">

                  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                </svg>
              </button>
              <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#deleteModal" id="delete_Button" data-id="<?php echo $row['id']; ?>" data-nev="<?php echo $row['nev'];?>" data-terulet="<?php echo $row['ter_id'];?>" data-pozicio="<?php echo $row['pozi_id'] ?>" data-allapot="<?php echo $row['állapot_id']; ?>">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-x-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z"/>
                </svg>
              </button>
            </td>
          </tr>
          <?php
          }else if ($row["állapot_id"] == '3') { 
            ?>
            <tr class="table-info" id="<?php echo $row['id'];?>">
            <td id="d_nev"><?php echo $row["nev"]; ?></td>
            <td id="d_ter" data-id="<?php echo $row['ter_id']; ?>"><?php echo $row["terület"]; ?></td>
            <td id="d_pozi" data-id="<?php echo $row['pozi_id']; ?>"><?php echo $row["pozi"]; ?></td>
            <td id="d_allapot" data-id="<?php echo $row['állapot_id']; ?>"><?php echo $row["állapot"]; ?></td>
            <td>
              <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal" id="modalButton" data-whatever="<?php echo $row['nev'];?>" data-id="<?php echo $row['id'];?>" data-terulet="<?php echo $row['ter_id'];?>" data-pozicio="<?php echo $row['pozi_id'] ?>" data-allapot="<?php echo $row['állapot_id']; ?>">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">

                  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                </svg>
              </button>
              <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#deleteModal" id="delete_Button" data-id="<?php echo $row['id']; ?>" data-nev="<?php echo $row['nev'];?>" data-terulet="<?php echo $row['ter_id'];?>" data-pozicio="<?php echo $row['pozi_id'] ?>" data-allapot="<?php echo $row['állapot_id']; ?>">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-x-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z"/>
                </svg>
              </button>
            </td>
          </tr>
          <?php
          }else if ($row["állapot_id"] == '5') { ?>
            <tr class="table-secondary" id="<?php echo $row['id'];?>">
            <td id="d_nev"><?php echo $row["nev"]; ?></td>
            <td id="d_ter" data-id="<?php echo $row['ter_id']; ?>"><?php echo $row["terület"]; ?></td>
            <td id="d_pozi" data-id="<?php echo $row['pozi_id']; ?>"><?php echo $row["pozi"]; ?></td>
            <td id="d_allapot" data-id="<?php echo $row['állapot_id']; ?>"><?php echo $row["állapot"]; ?></td>
            <td>
              <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal" id="modalButton" data-whatever="<?php echo $row['nev'];?>" data-id="<?php echo $row['id'];?>" data-terulet="<?php echo $row['ter_id'];?>" data-pozicio="<?php echo $row['pozi_id'] ?>" data-allapot="<?php echo $row['állapot_id']; ?>">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">

                  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                </svg>
              </button>
              <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#deleteModal" id="delete_Button" data-id="<?php echo $row['id']; ?>" data-nev="<?php echo $row['nev'];?>" data-terulet="<?php echo $row['ter_id'];?>" data-pozicio="<?php echo $row['pozi_id'] ?>" data-allapot="<?php echo $row['állapot_id']; ?>">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-x-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z"/>
                </svg>
              </button>
            </td>
          </tr>
          <?php
          }elseif ($row["állapot_id"] == "4") { ?>
           <tr class="table-light" id="<?php echo $row['id'];?>">
            <td id="d_nev"><?php echo $row["nev"]; ?></td>
            <td id="d_ter" data-id="<?php echo $row['ter_id']; ?>"><?php echo $row["terület"]; ?></td>
            <td id="d_pozi" data-id="<?php echo $row['pozi_id']; ?>"><?php echo $row["pozi"]; ?></td>
            <td id="d_allapot" data-id="<?php echo $row['állapot_id']; ?>"><?php echo $row["állapot"]; ?></td>
            <td>
              <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal" id="modalButton" data-whatever="<?php echo $row['nev'];?>" data-id="<?php echo $row['id'];?>" data-terulet="<?php echo $row['ter_id'];?>" data-pozicio="<?php echo $row['pozi_id'] ?>" data-allapot="<?php echo $row['állapot_id']; ?>">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">

                  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                </svg>
              </button>
              <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#deleteModal" id="delete_Button" data-id="<?php echo $row['id']; ?>" data-nev="<?php echo $row['nev'];?>" data-terulet="<?php echo $row['ter_id'];?>" data-pozicio="<?php echo $row['pozi_id'] ?>" data-allapot="<?php echo $row['állapot_id']; ?>">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-x-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z"/>
                </svg>
              </button>
            </td>
          </tr>
          <?php  
          } else{
          ?>  
          <tr id="<?php echo $row['id'];?>" class="table-success">
            <td id="d_nev"><?php echo $row["nev"]; ?></td>
            <td id="d_ter" data-id="<?php echo $row['ter_id']; ?>"><?php echo $row["terület"]; ?></td>
            <td id="d_pozi" data-id="<?php echo $row['pozi_id']; ?>"><?php echo $row["pozi"]; ?></td>
            <td id="d_allapot" data-id="<?php echo $row['állapot_id']; ?>"><?php echo $row["állapot"]; ?></td>
            <td>
              <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal" id="modalButton" data-whatever="<?php echo $row['nev'];?>" data-id="<?php echo $row['id'];?>" data-terulet="<?php echo $row['ter_id'];?>" data-pozicio="<?php echo $row['pozi_id'] ?>" data-allapot="<?php echo $row['állapot_id']; ?>">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">

                  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                </svg>
              </button>
              <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#deleteModal" id="delete_Button" data-id="<?php echo $row['id']; ?>" data-nev="<?php echo $row['nev'];?>" data-terulet="<?php echo $row['ter_id'];?>" data-pozicio="<?php echo $row['pozi_id'] ?>" data-allapot="<?php echo $row['állapot_id']; ?>">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-x-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z"/>
                </svg>
              </button>
            </td>
          </tr>
          <?php
          }
          ?>
    			
    		
    			
    			<?php
    			
    			if ($row["állapot_id"] == "1") {
    			
    			$db++;
    		}
  		}	
		} else {
  			echo "<tr >
		<td colspan='5'>No Result found !</td>
		</tr>";
		}
	?>