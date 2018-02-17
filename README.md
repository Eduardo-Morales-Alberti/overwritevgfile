# Exclude vagrant projects folders
This allows to you exclude projects folders to be sync.

## Instructions
1. Create a file called *'config.json'*.
   Here is an example of what needs to be on it.
```
{
  "projects": {
    "alias": "name-folder",
    "other-alias": "name-folder"
  },
  "vgfile": "vagrantfiledir/VagrantFile"
}
```
> **'alias'** will be the name of your project when you write it in the command line.
> It is easiest than write the folder name.

> Also replace **'vagrantfiledir'** with your VagrantFile directory.

2. Execute the file with `php excludevgprojects.php`
3. Then it will ask about the projects that you want to use.
   **You must write each project with a comma and space.** like this *'pro1, pro2'*
