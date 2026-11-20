# Descasio for WordPress

The Descasio website as a WordPress theme and an elements plugin. Pages are built and edited in **Elementor** or **WPBakery Page Builder**, and they keep exactly the same design, glass effects and motion as the Next.js site.

| Folder | What it is |
| --- | --- |
| `descasio-theme/` | The theme: design system, header with mega menu, footer, blog, light and dark modes |
| `descasio-elements/` | The plugin: 31 page elements for Elementor and WPBakery, forms, the Leads inbox and the page importer |
| `dist/` | Ready-to-install zip files of both |
| `build/` | Source files used to rebuild the CSS and the page content (developers only) |

## Requirements

- WordPress 6.4 or newer, PHP 8.0 or newer
- **Elementor** (the free version is enough) or **WPBakery Page Builder** (paid)

## Installation (about 5 minutes)

1. **Install the theme:** Appearance > Themes > Add New > Upload Theme > choose `dist/descasio-theme.zip` > Install > **Activate**.
2. **Install the plugin:** Plugins > Add New > Upload Plugin > choose `dist/descasio-elements.zip` > Install > **Activate**.
3. **Install your page builder** if it isn't already: Elementor from Plugins > Add New, or WPBakery from its own zip file.
4. **Choose the builder:** Descasio > Settings > select **Elementor**, **WPBakery** or **Both** > Save.
   On the same screen, enter the email address that should receive new leads.
5. **Import the pages:** Descasio > Import pages > **Import pages**.
   This creates all 22 pages (Home, Decision Intelligence Platform, Solutions, the seven service pages, PlugIQ, About, Partners, Careers, Case Studies, Contact, AI Readiness Assessment, Whitepapers, Events, Press, Privacy Policy and Blog), builds the main and footer menus, and sets the home page and the blog page.
6. **Set pretty links:** Settings > Permalinks > **Post name** > Save. Page addresses then match the current site, for example `/contact/`.

Pages that already exist are left alone unless you tick "Replace existing pages".

## Editing pages

### In Elementor
Open any page > **Edit with Elementor**. Click a section to edit its text, links, images, icons and lists in the left-hand panel. To add a section, search the panel for "Descasio" or open the **Descasio** category.

### In WPBakery
Open any page > **Backend Editor** or **Frontend Editor**. Each section is a Descasio element: click the pencil to edit it. Add new sections from **Add Element > Descasio**.

### Writing tips
- **Coloured words:** wrap words in curly braces to show them in the brand vermilion, for example `Real impact. {Real results.}`
- **Lists:** fields marked "one per line" take one item per line.
- **Icons:** type a Phosphor icon name from [phosphoricons.com](https://phosphoricons.com), for example `chart-line-up` or `shield-check`.
- **Links:** use a full address (`https://…`) or a page path (`/contact/`). Add `?topic=dip` to a contact link to preselect the DIP topic on the form.
- **Images:** leave the client logos or hero photos empty to use the bundled images, or choose your own from the Media Library.

## The elements

| Element | Used on |
| --- | --- |
| Home Hero, Statistics, Flagship Product Band (DIP), Client Logos, Sticky Heading + Cards, Bento Differentiators, Featured Results | Home |
| Product Hero with Evidence Trail, Icon Cards Grid, Accent Panel, Process Steps, Tabbed Cards, Numbered Points Panel, Offer + Event Cards, Evidence Trail | Decision Intelligence Platform |
| Page Hero, Service Details, Feature Rows | Inner pages, service pages, Solutions, Partners |
| Before and After Cards | PlugIQ |
| Values Grid, Team Members | About |
| Open Roles | Careers |
| Case Study Grid, Downloads (Whitepapers), Press Timeline, Event Card, Latest Posts | Resources |
| Contact Form, AI Readiness Assessment | Contact, AI Readiness |
| Call to Action Band, Section Heading | Anywhere |

Every element is also available as a shortcode, for example `[descasio_cta_band title="Ready to talk?"]`, so it works in the block editor's Shortcode block too. Descasio > Settings lists them all.

## Leads

Contact form and AI Readiness Assessment submissions are saved under **Leads** in the admin menu and emailed to the address in Descasio > Settings. Each lead shows the person's details and, for the assessment, their score per dimension. Spam protection (a hidden honeypot field and a rate limit) is built in.

> For reliable email delivery, install an SMTP plugin such as WP Mail SMTP. Many hosts block WordPress's default mail.

## Site settings

Appearance > Customize > **Descasio**:
- **Brand and contact:** logos for light and dark backgrounds, the main button (label and link, for example Calendly), email, phone, address and footer text.
- **Mega menu:** the featured card in the Solutions menu (DIP by default) and the menu footer links.

Menus are edited in Appearance > Menus. Each menu item has an **Icon** field and uses its **Description** for the line under the link (turn on "Description" under Screen Options). A top-level item whose children have their own children becomes a mega menu, like Solutions.

## For developers

```bash
cd wordpress
npm install
npm run build          # copies icons and Lenis, compiles the CSS
npm run watch:css      # rebuild CSS while editing templates
node --experimental-strip-types build/export-pages.mjs   # regenerate the importer's page content from src/content
php descasio-elements/bin/generate-elementor-classes.php  # after adding or renaming an element
bash build/package.sh  # rebuild the zips in dist/
```

- **Adding an element:** create `descasio-elements/elements/my_element.php` returning a title, icon, a field list and a render function (copy an existing element). Run the class generator above. Elementor, WPBakery and the shortcode are all generated from that one file.
- **Styling:** the CSS is Tailwind v4, compiled from `build/descasio.css`, which holds the same design tokens as the Next.js site. Use the existing utility classes in templates, then run `npm run build:css`.
- **Page-builder resets:** Elementor and WordPress ship image and figure rules outside Tailwind's cascade layers. `build/descasio.css` hands those properties back to the design system with `revert-layer`. Keep that block if you upgrade Tailwind.

All rights reserved. © Descasio Technology.
