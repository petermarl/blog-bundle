# FlowFusion/BlogBundle
The FlowFusionBlogBundle is a expandable Bundle for the Symfony PHP-Framework and brings basic features for standard blog functionality of a website.

## Content overview  
1. Install the Blog Bundle 
1. Register the required bundles
1. Bundle configuration
1. Routing 
1. Security
1. Done

## Install the Blog Bundle

Simply install it via composer:

`composer require flowfusion/blog-bundle`

This command installs all required bundles and libs, including

*	knplabs/knp-menu-bundle
*	knplabs/knp-paginator-bundle
*	cocur/slugify
*	flowfusion/user-bundle

## Register the required bundles
After installation, register all required bundles in AppKernel.php:

```<?php
// app/AppKernel.php
 
public function registerBundles()
{
    $bundles = array(
        // ...
		new FOS\UserBundle\FOSUserBundle(),
        new FlowFusion\UserBundle\FlowFusionUserBundle(),
		new FlowFusion\BlogBundle\FlowFusionBlogBundle(),
		new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
		new Knp\Bundle\MenuBundle\KnpMenuBundle(),
        // ...
    );
}```

## Bundle configuration
After bundle registration, you will get some error messages, because the configuration isn't ready. So, create it with this example:

```# app/config/config.yml

swiftmailer:
    transport: '%mailer_transport%'
    host: '%mailer_host%'
    username: '%mailer_user%'
    password: '%mailer_password%'
    spool: { type: memory }

fos_user:
    db_driver: orm # other valid values are 'mongodb' and 'couchdb'
    firewall_name: main
    user_class: FlowFusion\UserBundle\Entity\User # Read the "Extend the bundle" part of the documentation to know how to change the user class
    from_email:
        address: "%mailer_user%"
        sender_name: "%mailer_user%"

knp_paginator:
    page_range: 5                      # default page range used in pagination control
    default_options:
        page_name: page                # page query parameter name
        sort_field_name: sort          # sort field query parameter name
        sort_direction_name: direction # sort direction query parameter name
        distinct: true                 # ensure distinct results, useful when ORM queries are using GROUP BY statements
    template:
        pagination: 'KnpPaginatorBundle:Pagination:sliding.html.twig'     # sliding pagination controls template
        sortable: 'KnpPaginatorBundle:Pagination:sortable_link.html.twig' # sort link template

knp_menu:
    twig:
        template: KnpMenuBundle::menu.html.twig
    templating: false
    default_renderer: twig

flow_fusion_blog:
    loop:
        page_limit: 20 				   # defines how many posts will be shown in lists
        excerpt_length: 150			   # the length of excerpts in lists
        read_more_link: true           # do you want to show the "read more" link on excerpts?```

## Routing
Now, it's required to include the routing files:
```# app/config/routing.yml

flow_fusion_blog_view:
    resource: "@FlowFusionBlogBundle/Resources/config/routing_view.yml"
    prefix:   /blog # this can be changed

flow_fusion_blog_admin:
    resource: "@FlowFusionBlogBundle/Resources/config/routing_admin.yml"
    prefix:   /admin # this can be changed. "/admin/blog" for example...

fos_user:
    resource: "@FOSUserBundle/Resources/config/routing/all.xml"``

## Security
Because the FlowFusionBlogBundle have his own admin backend, we need to create a security configuration. Please also read the docs of FOSUserBundle for security (step 4) to understand how it works.
This is the basic security configuration:
```# app/config/security.yml

security:
    encoders:
        FOS\UserBundle\Model\UserInterface: bcrypt

    role_hierarchy:
        ROLE_ADMIN:       ROLE_USER
        ROLE_SUPER_ADMIN: ROLE_ADMIN

    providers:
        fos_userbundle:
            id: fos_user.user_provider.username_email

    firewalls:
        main:
            pattern: ^/
            form_login:
                provider: fos_userbundle
                csrf_token_generator: security.csrf.token_manager
                # if you are using Symfony < 2.8, use the following config instead:
                # csrf_provider: form.csrf_provider

            logout:       true
            anonymous:    true

    access_control:
        - { path: ^/login$, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/register, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/resetting, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/admin/, role: ROLE_ADMIN }
```

## Done
Now, you can start using the bundle!
