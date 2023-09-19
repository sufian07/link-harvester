# Link Harvester

Link Harvester is a simple app which collects links from users. Any user can submit links
which are validated and stored by the application. Users can see the submitted
(links/domains) and search, sort those data. The results are displayed in a paginated table.
## Setup
- Docker and make need to installed in your system
- run `make setup` for first time it will start the detached server
- run `make up` when you already setup
## Technical Requirements:
1. Install a fresh Laravel 10 application
2. Create a page called “Add URLs”
a. The page will contain a form with a textarea and a Submit button
b. We will add about 5000+ URLs at once
c. Each URL will be separated with new line
d. The page should be designed using Alpine.js or preact or something
equivalent.
3. Apply FormRequest validation after Submit. Each URL should be a valid URL.
4. Create a Laravel Job with the submitted data,
    - a. The background job will process the data and store in database
    - b. Background job will be processed by ubuntu supervisor
    - c. Please create 2 tables to save the URLs, one table will contain the base domain name of URLs and another table will contain the corresponding URLs of that domain.
    - d. The URLs must be unique throughout the system
5. Create another page called “Show URLs”, which will show the domain name and
URLs from the database (with searching, sorting and pagination)
6. Containerize the application using Docker, Docker Compose
    - a. Dockerfile must be written by hand, avoid using Laravel Sail
    - b. Docker compose should contain 4 services:
        - i. Laravel app: Built using dockerfile
        - ii. Database (MySql/PostgreSQL/Equivalent): Database to store app
        data
        - iii. Apache/Nginx: Web server to host the app.
        - iv. Scheduler: Container that runs the background job
    c. Deploy the containers in a registry (Github or Gitlab or equivalent)
## Multi Architecture Support (Optional):
This is an optional requirement. If you find it challenging, you can skip this.

    - a. Suppose we have two servers, one has an Intel Processor with x86
    architecture and the other one has an ARM processor with RISC architecture.
    - b. We want our container images to be able to run on both kinds of machines.
    - c. Modify existing Dockerfiles so this can be supported. Hint: Use Docker Buildx
    - d. Optimize the Dockerfile, so the build stage (intermediate stage/layer) is not recreated for each architecture.
## Guidelines:
- Well written README.md which includes details on how to build, deploy the full
application.
- Follow Laravel best practices
- Follow Docker, Docker Security best practices
- Clean code
