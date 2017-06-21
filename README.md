# resources_list_plugin
Wordpress Plugin to create resource lists for academic libraries

## Input:
Users insert ISBNs into a WP custom post type 

## Output:
For the time being, this plugin is designed to output data from these custom post types into lists that users can share with the WP API. Lists are curated by the plugin's taxonomy. 

## Install:
Create a folder in wordpress titled, "resource-lists" and insert files from this repo.

## Finding data from the API
To access lists, use the URL path for accessing taxonomies with WP's API, here's an example:

{{your_base_URL}}/wp-json/wp/v2/resource-list-record?resource_list_parent={{tax_ID#}}&_embed=true

### Future Development Features:
Using the WP API from this Plugin, we will be able to:
- Create a slideshow of new books with book covers, biblio data, and links to catalogs
- Slidehow widget that can be embedded into other websites
- HTML formatted lists that can be copy and pasted into email body
