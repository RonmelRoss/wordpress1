# Change Log

All notable changes to this project will be documented in this file.
See [Conventional Commits](https://conventionalcommits.org) for commit guidelines.

## 1.5.1 (2021-02-02)


### chore

* hotfix remove function which does not exist in < WordPress 5.5





# 1.5.0 (2021-02-02)


### feat

* introduce new checkbox to enable automatic minor and patch updates (CU-dcyf6c)





## 1.4.5 (2021-01-24)


### fix

* avoid duplicate feedback modals if other plugins of us are active (e.g. RML, CU-cx0ynw)





## 1.4.4 (2021-01-11)


### build

* reduce javascript bundle size by using babel runtime correctly with webpack / babel-loader


### chore

* **release :** publish [ci skip]





## 1.4.3 (2020-12-09)


### chore

* update to webpack v5 (CU-4akvz6)
* updates typings and min. Node.js and Yarn version (CU-9rq9c7)


### fix

* add hint for installation type for better explanation (CU-b8t6qf)





## 1.4.2 (2020-12-01)


### chore

* update dependencies (CU-3cj43t)
* update to composer v2 (CU-4akvjg)


### refactor

* enforce explicit-member-accessibility (CU-a6w5bv)





## 1.4.1 (2020-11-26)


### chore

* **release :** publish [ci skip]


### fix

* show link to account page when max license usage reached (CU-aq0g1g)





# 1.4.0 (2020-11-24)


### feat

* add hasInteractedWithFormOnce property of current blog to REST response (CU-agzcrp)


### fix

* license form was not localized to german (CU-agzcrp)
* use no-store caching for WP REST API calls to avoid issues with browsers and CloudFlare (CU-agzcrp)





## 1.3.4 (2020-11-19)


### fix

* deactivation feedback wrong REST route





## 1.3.3 (2020-11-18)


### fix

* deactivation feedback modal





## 1.3.2 (2020-11-17)


### fix

* duplicate error messages (#acypm6)





## 1.3.1 (2020-11-17)


### fix

* correctly show multisite blogname (#acwzpy)





# 1.3.0 (2020-11-03)


### feat

* allow to disable announcements (#9jwehz)
* translation (#8mrn5a)





# 1.2.0 (2020-10-23)


### feat

* route PATCH PaddleIncompleteOrder (#8ywfdu)


### fix

* typing


### refactor

* use "import type" instead of "import"





# 1.1.0 (2020-10-16)


### build

* use node modules cache more aggressively in CI (#4akvz6)


### chore

* introduce Real Product Manager WordPress client package (#8cxk67)
* update PUC (#8cxk67)
* update PUC (#8cxk67)


### feat

* add checklist in config page header (#8cxk67)
* announcements (#8cxk67)
* introduce feedback modal (#8cxk67)


### fix

* enable old auto updater instead of new one for EA (#8cxk67)
* review 1 (#8cxk67)
* review 2 (#8cxk67)
* review 3 (#8cxk67)
* review 4 (#8cxk67)
* validate response in PUC (#8cxk67)





# 1.1.0 (2020-10-16)


### build

* use node modules cache more aggressively in CI (#4akvz6)


### chore

* introduce Real Product Manager WordPress client package (#8cxk67)
* update PUC (#8cxk67)
* update PUC (#8cxk67)


### feat

* add checklist in config page header (#8cxk67)
* announcements (#8cxk67)
* introduce feedback modal (#8cxk67)


### fix

* enable old auto updater instead of new one for EA (#8cxk67)
* review 1 (#8cxk67)
* review 2 (#8cxk67)
* review 3 (#8cxk67)
* review 4 (#8cxk67)
* validate response in PUC (#8cxk67)
