<?php
class Programming {
	function now() {
  	$currentPlay = false;
    if(file_exists('../programming/'.date('mdY').'-TOA/TOA-'.date('mdY-H').'.txt')){
  		$currentProgramming = file_get_contents('../programming/'.date('mdY').'-TOA/TOA-'.date('mdY-H').'.txt');
  		$currentProgramming = explode("\n",$currentProgramming);

  		foreach($currentProgramming as $key=>$row){
  			$row = trim($row, '" "');
  			$row = explode('","',$row);

  			$currentProgramming[$key] = $row;
  		}


  		foreach($currentProgramming as $key=>$row){
  			if(isset($row[3])){
  				list($hours,$mins,$secs,$ms) = explode(':',$row[3]);
  				$seconds = mktime($hours,$mins,$secs) - mktime(0,0,0);
  				if($seconds>50){
  					$playTime = strtotime($row[2]." ".substr($row[1],0,-3));
  					$endTime = strtotime('+'.$hours.' hour +'.$mins.' minutes +'.$secs.' seconds',$playTime);

  					$currentTime = strtotime("now");
  					$row[5] = $playTime-$currentTime;
  					$row[6] = $endTime-$currentTime;


  					if($row[5]<0&&$row[6]>0){
  						$currentPlay = $row;
  						break;
  					}
  /*
  					if($row[5]<0){
  						$currentPlay = $row;
  // 						break;
  					}
  */
  				}
  			}
  		}

  		if($currentPlay){
  			$meta = $currentPlay[0];
  			$meta = explode("-",$meta);
  			unset($meta[0]);
  			$meta = implode(" ",$meta);
  			$meta = explode("_",$meta);

  			$artist = str_replace("ft ", "feat ",$meta[0]);
  			$title = str_replace("ft ", "feat ", $meta[1]);

  			$currentPlay[7] = $artist;
  			$currentPlay[8] = $title;

  			$musix = new MusicXMatch('57259514fe97d9332912ff77bda15492');
  			$musix->setEndpoint('track.search');
  			$result = null;
  			$musix->param_q_track($title);
  			$musix->param_q_artist($artist);
  			$musix->param_page_size(100);
  			try{
  			  $result = $musix->execute_request();
  			} catch (Exception $e){
  			    d($e);
  			}
  			if($result){
  				foreach($result['track_list'] as $track){
  					if((strtolower($track['track']['track_name'])==strtolower($title)
  							|| strtolower(str_replace("'",'',$track['track']['track_name']))==strtolower($title))
  						&&$track['track']['has_lyrics']==1){
  						$currentPlay[9] = $track;
  						break;
  					}
  				}
  			}
  		}


  		if(isset($currentPlay[9])){
  			$lyrics = new MusicXMatch('57259514fe97d9332912ff77bda15492');
  			$lyrics->setEndpoint('track.lyrics.get');
  			$lyrics->param_track_id($currentPlay[9]['track']['track_id']);
  			try{
  			  $currentPlay[10] = $lyrics->execute_request();
  				$currentPlay[10]['lyrics']['lyrics_body'] = str_replace("******* This Lyrics is NOT for Commercial use *******",'',$currentPlay[10]['lyrics']['lyrics_body']);
  			} catch (Exception $e){
  			    d($e);
  			}
  		}

    }

		return $currentPlay;
	}
	function next() {
  	$currentPlay = false;
    if(file_exists('../programming/'.date('mdY').'-TOA/TOA-'.date('mdY-H').'.txt')){
  		$currentProgramming = file_get_contents('../programming/'.date('mdY').'-TOA/TOA-'.date('mdY-H').'.txt');
  		$currentProgramming = explode("\n",$currentProgramming);
  		$currentPlay = false;

  		foreach($currentProgramming as $key=>$row){
  			$row = trim($row, '" "');
  			$row = explode('","',$row);

  			$currentProgramming[$key] = $row;
  		}


  		foreach($currentProgramming as $key=>$row){
  			if(isset($row[3])){
  				list($hours,$mins,$secs,$ms) = explode(':',$row[3]);
  				$seconds = mktime($hours,$mins,$secs) - mktime(0,0,0);
  				if($seconds>50){
  					$playTime = strtotime($row[2]." ".substr($row[1],0,-3));
  					$endTime = strtotime('+'.$hours.' hour +'.$mins.' minutes +'.$secs.' seconds',$playTime);

  					$currentTime = strtotime("now");
  					$row[5] = $playTime-$currentTime;
  					$row[6] = $endTime-$currentTime;


  					if($row[5]>0){
  						$currentPlay = $row;
  						break;
  					}
  /*
  					if($row[5]<0){
  						$currentPlay = $row;
  // 						break;
  					}
  */
  				}
  			}
  		}
    }

		return $currentPlay;

	}
}
