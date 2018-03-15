<?php

$actual_dir = posix_getcwd();

// Obtain all projects from json file.
$str = file_get_contents($actual_dir . '/config.json');

// Converting json into array.
$array_file = json_decode($str, TRUE);

$keys = array_keys($array_file['projects']);

$options = implode(" / ", $keys);
shell_exec('echo ');
$message = "Projects available: " . $options . " (separate it with comma to not exclude): ";

// Obtain from command line projects to exclude.
$exclude_pro = readline($message);

// Converting exclude projects to array.
$array_exclude_pro = explode(', ', $exclude_pro);

// Obtain vagrant file.
$vgfile = file_get_contents($array_file['vgfile']);

// Adding exlude projects from command line to the all projects array.
$array_file['not_excluded'] = $array_exclude_pro;
$projectsvg = '';

// Going throught the projects.
foreach ($array_file['projects'] as $project => $dir) {

  // Pattern commentted projects.
  $commented = '# "' . $dir[0] . '",';

  // Pattern exclude projects.
  $excluded = '"' . $dir[0] . '",';

  // Project is commented.
  $has_comment = preg_match('/' . $commented . '/', $vgfile);

  // Is excluded but maybe is commented.
  $is_exc = preg_match('/' . $excluded . '/', $vgfile);

  // If the actual project is not in "not excluded" array but is commented
  // in file, the project will be uncommented to exluded that project.
  if (!in_array($project, $array_file['not_excluded']) && $has_comment) {

    $vgfile = preg_replace('/' . $commented . '/', $excluded, $vgfile);
  }
  // If it is not commented but it is excluded, it will be commented.
  elseif (!$has_comment && $is_exc && in_array($project, $array_file['not_excluded'])) {
    $vgfile = preg_replace('/' . $excluded . '/', $commented, $vgfile);
  }
}

file_put_contents($array_file['vgfile'], $vgfile);
file_put_contents($actual_dir . '/config.json', json_encode($array_file));

?>
