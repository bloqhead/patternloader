# Design Pattern Library Loader
A simple PHP-driven design pattern library loader. Read about it on the [Big Sea Blog](http://bigseadesign.com/web-design/following-patterns).

## Getting Started
1. Rename the parameters in the `project.json` file to match your project. This is optional but makes thing a little more presentable and personalized
2. Create your individual Scss, Coffeescript and Javascript files in their corresponding folders in the `/public/assets/` directory
3. To automate things and save time, James wrote a Bash script that will generate your pattern HTML files based on the names of your Scss files. Run `genpattern` via Terminal to do the job:<br/>
`$ ./genpattern`
4. Start writing your design pattern HTML in the files generated in step 3
3. To display your patterns, open `index.php` in your web browser

## Personalization
We use this for our projects, thus we've styled it a bit to match our own company colors. If you would rather have the default styles, simply remove the `bigsea` class from the body in `index.php`.

## Credits
Front-End Web Developer [Daryn St. Pierre](http://bigseadesign.com/team/daryn-st-pierre) and Lead Developer [James Sylvanus](http://bigseadesign.com/team/james-sylvanus) with [Big Sea Design](http://bigseadesign.com) in sunny St. Petersburg Florida.

[View the license](LICENSE).
