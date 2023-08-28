# GIG College Essay Writer

**Contributors:** Clarissa Chen and Gordon Yee

## Description

A plugin and page template that integrates GIG's College Essay Writer with your WordPress site.

## Installation
Download `gig-custom-plugin.zip` and `generate-page-template.php` from this repository.

### Custom Plugin
1. In the WordPress dashboard, go to the `Plugins` section. You can usually find it on the left-hand menu. Click on `Plugins` to access the plugins management page.
2. On the `Plugins` page, there will be an `Add New` button near the top. Click on it to proceed.
3. Click on the `Upload Plugin` button located at the top of the page.
4. Click the `Choose File` button and select the `gig-custom-plugin.zip` file.
5. Once you've selected the .zip file, click the `Install Now` button. WordPress will begin the process of uploading and installing your plugin.
6. After the plugin is successfully installed, you'll see a success message. From there, you can click the `Activate Plugin` link. This will activate your custom plugin on your WordPress website.

### Custom Page Template
1. Connect to your WordPress website's hosting server using FTP or a file manager provided by your hosting provider. Navigate to the directory where your WordPress theme is located, usually in the `wp-content/themes/` folder. Upload the `generate-page-template.php` file to your theme's folder.

## Usage

### Custom Plugin
1. Upon plugin activation, a new tab titled `GIG` will be added to WP admin dashboard `Settings`. Select this page by clicking "Settings" and selecting `GIG`.
>![gig-settings-screenshot](screenshots/gig-settings.png)
2. Enter your API `User ID` and `User Key` in the respective fields.
3. Click `Save Changes`. Your API ID and Key will now be stored in the WordPress Database for future use.
>![gig-settings-screenshot](screenshots/gig-settings-save-changes.png)

### Custom Page Template

>**Assign the Template to a Page:** <br>
Now that your template is uploaded, go to your WordPress dashboard and create or edit a page where you want to use the custom template. In the `Page Attributes` section on the right-hand side, you'll see `Template` in the summary. It will likely be set to `Default template`. Click on `Default template` or whatever template is listed there to open the template dropdown menu. Once the dropdown menu is opened, and you should see the `Generate Page` template listed there. Select `Generate Page`.

>**Publish or Update the Page:** <br>
After selecting the `Generate Page` template, click the `Publish` button if you're creating a new page or the `Update` button if you're editing an existing page. The page will now use the layout and structure defined in `Generate Page` template.

>**View the Page:** <br>
Visit the page on your website that you assigned the `Generate Page` template to. You should see the layout and design defined in the `generate-page-template.php` file.

### User Flow
1. Fill out and submit a response to the CV Input form (Gravity Forms).
2. Click on the page that the `Generate Page` template is active.

**prompt-table.php**
>Displays table of prompts from wp_gig_prompts for selection by the user and a custom prompt form for user input. The user controls which prompt to use by selecting the corresponding checkbox on the right of the prompt they desire to use. 

**cv-table.php**
>Displays table of all CV form entries by the user. Checkboxes allow the user to select which CV form sections they would like to include from the CV form entry of their choice in the essay generation. 

**api-calls.php**
>Contains GIG API calls

**wp_gig_user_history_table**
>Stores all user generation activity. (Prompt used, user inputs selected, generated response, etc.)

**wp_gig_prompts**
>Stores common College application prompts that are sent to be displayed on the page.  

**wp_usermeta**
>user_credits_used - Tracks how many times the user calls the essay generator API (AKA how many credits the user has used). This is stored in the table "wp_usermeta".