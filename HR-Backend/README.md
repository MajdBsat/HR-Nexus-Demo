# HR-Nexus API Documentation

This document provides an overview of all available API endpoints in the HR-Nexus backend system.

## Authentication

| Method | Endpoint             | Description                                |
| ------ | -------------------- | ------------------------------------------ |
| POST   | `/api/auth/register` | Register a new user                        |
| POST   | `/api/auth/login`    | Login and get authentication token         |
| POST   | `/api/auth/logout`   | Logout (requires JWT)                      |
| POST   | `/api/auth/refresh`  | Refresh JWT token (requires JWT)           |
| GET    | `/api/auth/me`       | Get authenticated user info (requires JWT) |

## Users

| Method | Endpoint          | Description         |
| ------ | ----------------- | ------------------- |
| GET    | `/api/users`      | List all users      |
| POST   | `/api/users`      | Create a new user   |
| GET    | `/api/users/{id}` | Get a specific user |
| PUT    | `/api/users/{id}` | Update a user       |
| DELETE | `/api/users/{id}` | Delete a user       |

## Departments

| Method | Endpoint                | Description               |
| ------ | ----------------------- | ------------------------- |
| GET    | `/api/departments`      | List all departments      |
| POST   | `/api/departments`      | Create a new department   |
| GET    | `/api/departments/{id}` | Get a specific department |
| PUT    | `/api/departments/{id}` | Update a department       |
| DELETE | `/api/departments/{id}` | Delete a department       |

## Jobs

| Method | Endpoint                            | Description               |
| ------ | ----------------------------------- | ------------------------- |
| GET    | `/api/jobs`                         | List all jobs (public)    |
| POST   | `/api/jobs`                         | Create a new job          |
| GET    | `/api/jobs/{id}`                    | Get a specific job        |
| PUT    | `/api/jobs/{id}`                    | Update a job              |
| DELETE | `/api/jobs/{id}`                    | Delete a job              |
| GET    | `/api/jobs/status/{status}`         | Get jobs by status        |
| GET    | `/api/jobs/department/{department}` | Get jobs by department    |
| GET    | `/api/jobs/type/{jobType}`          | Get jobs by type          |
| GET    | `/api/jobs/active`                  | Get active jobs           |
| GET    | `/api/jobs/location/{location}`     | Get jobs by location      |
| GET    | `/api/jobs/remote/{isRemote}`       | Get jobs by remote status |
| POST   | `/api/jobs/search`                  | Search jobs               |

## Job Applications

| Method | Endpoint                                | Description                           |
| ------ | --------------------------------------- | ------------------------------------- |
| GET    | `/api/job-applications`                 | List all job applications             |
| POST   | `/api/job-applications`                 | Create a job application              |
| GET    | `/api/job-applications/{id}`            | Get a specific job application        |
| PUT    | `/api/job-applications/{id}`            | Update a job application              |
| DELETE | `/api/job-applications/{id}`            | Delete a job application              |
| GET    | `/api/job-applications/job/{jobId}`     | Get applications for a specific job   |
| GET    | `/api/job-applications/user/{userId}`   | Get applications from a specific user |
| GET    | `/api/job-applications/status/{status}` | Get applications by status            |
| POST   | `/api/job-applications/date-range`      | Get applications in a date range      |
| GET    | `/api/job-applications/recent/{days?}`  | Get recent applications               |

## Tasks

| Method | Endpoint                         | Description                  |
| ------ | -------------------------------- | ---------------------------- |
| GET    | `/api/tasks`                     | List all tasks               |
| POST   | `/api/tasks`                     | Create a new task            |
| GET    | `/api/tasks/{id}`                | Get a specific task          |
| PUT    | `/api/tasks/{id}`                | Update a task                |
| DELETE | `/api/tasks/{id}`                | Delete a task                |
| GET    | `/api/tasks/status/{status}`     | Get tasks by status          |
| GET    | `/api/tasks/priority/{priority}` | Get tasks by priority        |
| GET    | `/api/tasks/user/{userId}`       | Get tasks assigned to a user |
| GET    | `/api/tasks/upcoming/{days?}`    | Get upcoming tasks           |

## HR Projects

| Method | Endpoint                               | Description                      |
| ------ | -------------------------------------- | -------------------------------- |
| GET    | `/api/hr-projects`                     | List all HR projects             |
| POST   | `/api/hr-projects`                     | Create a new HR project          |
| GET    | `/api/hr-projects/{id}`                | Get a specific HR project        |
| PUT    | `/api/hr-projects/{id}`                | Update an HR project             |
| DELETE | `/api/hr-projects/{id}`                | Delete an HR project             |
| GET    | `/api/hr-projects/user/{userId}`       | Get HR projects by assigned user |
| GET    | `/api/hr-projects/status/{status}`     | Get HR projects by status        |
| GET    | `/api/hr-projects/priority/{priority}` | Get HR projects by priority      |
| GET    | `/api/hr-projects/upcoming/{days?}`    | Get upcoming HR projects         |

## HR Project Tasks

| Method | Endpoint                                          | Description                      |
| ------ | ------------------------------------------------- | -------------------------------- |
| GET    | `/api/hr-project-tasks`                           | List all HR project tasks        |
| POST   | `/api/hr-project-tasks`                           | Create a new HR project task     |
| GET    | `/api/hr-project-tasks/{id}`                      | Get a specific HR project task   |
| DELETE | `/api/hr-project-tasks/{id}`                      | Delete an HR project task        |
| GET    | `/api/hr-project-tasks/project/{projectId}/tasks` | Get tasks for a specific project |
| GET    | `/api/hr-project-tasks/task/{taskId}/projects`    | Get projects for a specific task |

## Insurance Plans

| Method | Endpoint                                   | Description                     |
| ------ | ------------------------------------------ | ------------------------------- |
| GET    | `/api/insurance-plans`                     | List all insurance plans        |
| POST   | `/api/insurance-plans`                     | Create a new insurance plan     |
| GET    | `/api/insurance-plans/{id}`                | Get a specific insurance plan   |
| PUT    | `/api/insurance-plans/{id}`                | Update an insurance plan        |
| DELETE | `/api/insurance-plans/{id}`                | Delete an insurance plan        |
| GET    | `/api/insurance-plans/type/{type}`         | Get insurance plans by type     |
| GET    | `/api/insurance-plans/status/{status}`     | Get insurance plans by status   |
| GET    | `/api/insurance-plans/provider/{provider}` | Get insurance plans by provider |
| GET    | `/api/insurance-plans/active`              | Get active insurance plans      |
| GET    | `/api/insurance-plans/user/{userId}`       | Get insurance plans for a user  |

## Health Care Plans

| Method | Endpoint                                             | Description                           |
| ------ | ---------------------------------------------------- | ------------------------------------- |
| GET    | `/api/healthcare-plans`                              | List all healthcare plans             |
| POST   | `/api/healthcare-plans`                              | Create a new healthcare plan          |
| GET    | `/api/healthcare-plans/{id}`                         | Get a specific healthcare plan        |
| PUT    | `/api/healthcare-plans/{id}`                         | Update a healthcare plan              |
| DELETE | `/api/healthcare-plans/{id}`                         | Delete a healthcare plan              |
| GET    | `/api/healthcare-plans/coverage-type/{coverageType}` | Get healthcare plans by coverage type |
| GET    | `/api/healthcare-plans/active`                       | Get active healthcare plans           |
| GET    | `/api/healthcare-plans/provider/{provider}`          | Get healthcare plans by provider      |
| GET    | `/api/healthcare-plans/user/{userId}`                | Get healthcare plans for a user       |

## Monthly Payrolls

| Method | Endpoint                                          | Description                                   |
| ------ | ------------------------------------------------- | --------------------------------------------- |
| GET    | `/api/monthly-payrolls`                           | List all monthly payrolls                     |
| POST   | `/api/monthly-payrolls`                           | Create a new monthly payroll                  |
| GET    | `/api/monthly-payrolls/{id}`                      | Get a specific monthly payroll                |
| PUT    | `/api/monthly-payrolls/{id}`                      | Update a monthly payroll                      |
| DELETE | `/api/monthly-payrolls/{id}`                      | Delete a monthly payroll                      |
| GET    | `/api/monthly-payrolls/month-year/{month}/{year}` | Get payrolls for a specific month and year    |
| GET    | `/api/monthly-payrolls/user/{userId}`             | Get payrolls for a user                       |
| GET    | `/api/monthly-payrolls/status/{status}`           | Get payrolls by status                        |
| GET    | `/api/monthly-payrolls/department/{departmentId}` | Get payrolls for a department                 |
| POST   | `/api/monthly-payrolls/date-range`                | Get payrolls in a date range                  |
| GET    | `/api/monthly-payrolls/total/{month}/{year}`      | Get total payroll amount for a month and year |
| POST   | `/api/monthly-payrolls/{id}/approve`              | Approve a payroll                             |
| POST   | `/api/monthly-payrolls/{id}/mark-paid`            | Mark a payroll as paid                        |
| POST   | `/api/monthly-payrolls/{id}/cancel`               | Cancel a payroll                              |

## Attendances

| Method | Endpoint                         | Description                            |
| ------ | -------------------------------- | -------------------------------------- |
| GET    | `/api/attendances`               | List all attendance records            |
| POST   | `/api/attendances`               | Create a new attendance record         |
| GET    | `/api/attendances/{id}`          | Get a specific attendance record       |
| PUT    | `/api/attendances/{id}`          | Update an attendance record            |
| DELETE | `/api/attendances/{id}`          | Delete an attendance record            |
| GET    | `/api/attendances/user/{userId}` | Get attendance records for a user      |
| POST   | `/api/attendances/date-range`    | Get attendance records in a date range |

## Base Salaries

| Method | Endpoint                           | Description                  |
| ------ | ---------------------------------- | ---------------------------- |
| GET    | `/api/base-salaries`               | List all base salaries       |
| POST   | `/api/base-salaries`               | Create a new base salary     |
| GET    | `/api/base-salaries/{id}`          | Get a specific base salary   |
| PUT    | `/api/base-salaries/{id}`          | Update a base salary         |
| DELETE | `/api/base-salaries/{id}`          | Delete a base salary         |
| GET    | `/api/base-salaries/user/{userId}` | Get base salaries for a user |

## Benefit Plans

| Method | Endpoint                           | Description                  |
| ------ | ---------------------------------- | ---------------------------- |
| GET    | `/api/benefit-plans`               | List all benefit plans       |
| POST   | `/api/benefit-plans`               | Create a new benefit plan    |
| GET    | `/api/benefit-plans/{id}`          | Get a specific benefit plan  |
| PUT    | `/api/benefit-plans/{id}`          | Update a benefit plan        |
| DELETE | `/api/benefit-plans/{id}`          | Delete a benefit plan        |
| GET    | `/api/benefit-plans/user/{userId}` | Get benefit plans for a user |
| GET    | `/api/benefit-plans/active`        | Get active benefit plans     |

## Candidates

| Method | Endpoint                              | Description                   |
| ------ | ------------------------------------- | ----------------------------- |
| GET    | `/api/candidates`                     | List all candidates           |
| POST   | `/api/candidates`                     | Create a new candidate        |
| GET    | `/api/candidates/{id}`                | Get a specific candidate      |
| PUT    | `/api/candidates/{id}`                | Update a candidate            |
| DELETE | `/api/candidates/{id}`                | Delete a candidate            |
| GET    | `/api/candidates/position/{position}` | Get candidates for a position |
| GET    | `/api/candidates/status/{status}`     | Get candidates by status      |
| POST   | `/api/candidates/search`              | Search candidates             |

## Compliance

| Method | Endpoint                          | Description                       |
| ------ | --------------------------------- | --------------------------------- |
| GET    | `/api/compliance`                 | List all compliance records       |
| POST   | `/api/compliance`                 | Create a new compliance record    |
| GET    | `/api/compliance/{id}`            | Get a specific compliance record  |
| PUT    | `/api/compliance/{id}`            | Update a compliance record        |
| DELETE | `/api/compliance/{id}`            | Delete a compliance record        |
| GET    | `/api/compliance/user/{userId}`   | Get compliance records for a user |
| GET    | `/api/compliance/status/{status}` | Get compliance records by status  |
| GET    | `/api/compliance/type/{type}`     | Get compliance records by type    |
| GET    | `/api/compliance/expiring`        | Get expiring compliance records   |

## Documents

| Method | Endpoint                             | Description               |
| ------ | ------------------------------------ | ------------------------- |
| GET    | `/api/documents`                     | List all documents        |
| POST   | `/api/documents`                     | Upload a new document     |
| GET    | `/api/documents/{id}`                | Get a specific document   |
| PUT    | `/api/documents/{id}`                | Update a document         |
| DELETE | `/api/documents/{id}`                | Delete a document         |
| GET    | `/api/documents/user/{userId}`       | Get documents for a user  |
| GET    | `/api/documents/category/{category}` | Get documents by category |
| GET    | `/api/documents/type/{documentType}` | Get documents by type     |
| POST   | `/api/documents/search`              | Search documents          |

## Roles

| Method | Endpoint                | Description          |
| ------ | ----------------------- | -------------------- |
| GET    | `/api/roles`            | List all roles       |
| POST   | `/api/roles`            | Create a new role    |
| GET    | `/api/roles/{id}`       | Get a specific role  |
| PUT    | `/api/roles/{id}`       | Update a role        |
| DELETE | `/api/roles/{id}`       | Delete a role        |
| GET    | `/api/roles/{id}/tasks` | Get tasks for a role |

## Onboarding Tasks

| Method | Endpoint                                           | Description                          |
| ------ | -------------------------------------------------- | ------------------------------------ |
| GET    | `/api/onboarding-tasks`                            | List all onboarding tasks            |
| POST   | `/api/onboarding-tasks`                            | Create a new onboarding task         |
| GET    | `/api/onboarding-tasks/{id}`                       | Get a specific onboarding task       |
| PUT    | `/api/onboarding-tasks/{id}`                       | Update an onboarding task            |
| DELETE | `/api/onboarding-tasks/{id}`                       | Delete an onboarding task            |
| GET    | `/api/onboarding-tasks/employee/{employeeId}`      | Get onboarding tasks for an employee |
| GET    | `/api/onboarding-tasks/role/{roleId}`              | Get onboarding tasks for a role      |
| GET    | `/api/onboarding-tasks/roles`                      | List all roles for onboarding        |
| GET    | `/api/onboarding-tasks/roles/{id}`                 | Get a specific role for onboarding   |
| POST   | `/api/onboarding-tasks/roles`                      | Create a new role for onboarding     |
| PUT    | `/api/onboarding-tasks/roles/{id}`                 | Update a role for onboarding         |
| DELETE | `/api/onboarding-tasks/roles/{id}`                 | Delete a role for onboarding         |
| GET    | `/api/onboarding-tasks/roles/{roleId}/tasks`       | Get tasks for a specific role        |
| POST   | `/api/onboarding-tasks/roles/assign-task`          | Assign a task to a role              |
| POST   | `/api/onboarding-tasks/roles/remove-task`          | Remove a task from a role            |
| POST   | `/api/onboarding-tasks/employee/assign-role-tasks` | Assign role tasks to an employee     |

## Authorization

The API has three main user types with different access levels:

1. **Guest** (user type 0): Can only view jobs and limited information.
2. **Employee** (user type 1): Can access their own tasks, applications, documents, and benefit information.
3. **HR** (user type 2): Has full access to manage all aspects of the HR system including insurance plans, benefits, roles, and onboarding tasks.

Some routes are available to all authenticated users, while others are restricted by user type.

# HR-Nexus API Documentation

This document provides an overview of all available API endpoints in the HR-Nexus backend system.

## Authentication

| Method | Endpoint             | Description                                |
| ------ | -------------------- | ------------------------------------------ |
| POST   | `/api/auth/register` | Register a new user                        |
| POST   | `/api/auth/login`    | Login and get authentication token         |
| POST   | `/api/auth/logout`   | Logout (requires JWT)                      |
| POST   | `/api/auth/refresh`  | Refresh JWT token (requires JWT)           |
| GET    | `/api/auth/me`       | Get authenticated user info (requires JWT) |

## Users

| Method | Endpoint          | Description         |
| ------ | ----------------- | ------------------- |
| GET    | `/api/users`      | List all users      |
| POST   | `/api/users`      | Create a new user   |
| GET    | `/api/users/{id}` | Get a specific user |
| PUT    | `/api/users/{id}` | Update a user       |
| DELETE | `/api/users/{id}` | Delete a user       |

## Departments

| Method | Endpoint                | Description               |
| ------ | ----------------------- | ------------------------- |
| GET    | `/api/departments`      | List all departments      |
| POST   | `/api/departments`      | Create a new department   |
| GET    | `/api/departments/{id}` | Get a specific department |
| PUT    | `/api/departments/{id}` | Update a department       |
| DELETE | `/api/departments/{id}` | Delete a department       |

## Jobs

| Method | Endpoint                            | Description               |
| ------ | ----------------------------------- | ------------------------- |
| GET    | `/api/jobs`                         | List all jobs (public)    |
| POST   | `/api/jobs`                         | Create a new job          |
| GET    | `/api/jobs/{id}`                    | Get a specific job        |
| PUT    | `/api/jobs/{id}`                    | Update a job              |
| DELETE | `/api/jobs/{id}`                    | Delete a job              |
| GET    | `/api/jobs/status/{status}`         | Get jobs by status        |
| GET    | `/api/jobs/department/{department}` | Get jobs by department    |
| GET    | `/api/jobs/type/{jobType}`          | Get jobs by type          |
| GET    | `/api/jobs/active`                  | Get active jobs           |
| GET    | `/api/jobs/location/{location}`     | Get jobs by location      |
| GET    | `/api/jobs/remote/{isRemote}`       | Get jobs by remote status |
| POST   | `/api/jobs/search`                  | Search jobs               |

## Job Applications

| Method | Endpoint                                | Description                           |
| ------ | --------------------------------------- | ------------------------------------- |
| GET    | `/api/job-applications`                 | List all job applications             |
| POST   | `/api/job-applications`                 | Create a job application              |
| GET    | `/api/job-applications/{id}`            | Get a specific job application        |
| PUT    | `/api/job-applications/{id}`            | Update a job application              |
| DELETE | `/api/job-applications/{id}`            | Delete a job application              |
| GET    | `/api/job-applications/job/{jobId}`     | Get applications for a specific job   |
| GET    | `/api/job-applications/user/{userId}`   | Get applications from a specific user |
| GET    | `/api/job-applications/status/{status}` | Get applications by status            |
| POST   | `/api/job-applications/date-range`      | Get applications in a date range      |
| GET    | `/api/job-applications/recent/{days?}`  | Get recent applications               |

## Tasks

| Method | Endpoint                         | Description                  |
| ------ | -------------------------------- | ---------------------------- |
| GET    | `/api/tasks`                     | List all tasks               |
| POST   | `/api/tasks`                     | Create a new task            |
| GET    | `/api/tasks/{id}`                | Get a specific task          |
| PUT    | `/api/tasks/{id}`                | Update a task                |
| DELETE | `/api/tasks/{id}`                | Delete a task                |
| GET    | `/api/tasks/status/{status}`     | Get tasks by status          |
| GET    | `/api/tasks/priority/{priority}` | Get tasks by priority        |
| GET    | `/api/tasks/user/{userId}`       | Get tasks assigned to a user |
| GET    | `/api/tasks/upcoming/{days?}`    | Get upcoming tasks           |

## HR Projects

| Method | Endpoint                               | Description                      |
| ------ | -------------------------------------- | -------------------------------- |
| GET    | `/api/hr-projects`                     | List all HR projects             |
| POST   | `/api/hr-projects`                     | Create a new HR project          |
| GET    | `/api/hr-projects/{id}`                | Get a specific HR project        |
| PUT    | `/api/hr-projects/{id}`                | Update an HR project             |
| DELETE | `/api/hr-projects/{id}`                | Delete an HR project             |
| GET    | `/api/hr-projects/user/{userId}`       | Get HR projects by assigned user |
| GET    | `/api/hr-projects/status/{status}`     | Get HR projects by status        |
| GET    | `/api/hr-projects/priority/{priority}` | Get HR projects by priority      |
| GET    | `/api/hr-projects/upcoming/{days?}`    | Get upcoming HR projects         |

## HR Project Tasks

| Method | Endpoint                                          | Description                      |
| ------ | ------------------------------------------------- | -------------------------------- |
| GET    | `/api/hr-project-tasks`                           | List all HR project tasks        |
| POST   | `/api/hr-project-tasks`                           | Create a new HR project task     |
| GET    | `/api/hr-project-tasks/{id}`                      | Get a specific HR project task   |
| DELETE | `/api/hr-project-tasks/{id}`                      | Delete an HR project task        |
| GET    | `/api/hr-project-tasks/project/{projectId}/tasks` | Get tasks for a specific project |
| GET    | `/api/hr-project-tasks/task/{taskId}/projects`    | Get projects for a specific task |

## Insurance Plans

| Method | Endpoint                                   | Description                     |
| ------ | ------------------------------------------ | ------------------------------- |
| GET    | `/api/insurance-plans`                     | List all insurance plans        |
| POST   | `/api/insurance-plans`                     | Create a new insurance plan     |
| GET    | `/api/insurance-plans/{id}`                | Get a specific insurance plan   |
| PUT    | `/api/insurance-plans/{id}`                | Update an insurance plan        |
| DELETE | `/api/insurance-plans/{id}`                | Delete an insurance plan        |
| GET    | `/api/insurance-plans/type/{type}`         | Get insurance plans by type     |
| GET    | `/api/insurance-plans/status/{status}`     | Get insurance plans by status   |
| GET    | `/api/insurance-plans/provider/{provider}` | Get insurance plans by provider |
| GET    | `/api/insurance-plans/active`              | Get active insurance plans      |
| GET    | `/api/insurance-plans/user/{userId}`       | Get insurance plans for a user  |

## Health Care Plans

| Method | Endpoint                                             | Description                           |
| ------ | ---------------------------------------------------- | ------------------------------------- |
| GET    | `/api/healthcare-plans`                              | List all healthcare plans             |
| POST   | `/api/healthcare-plans`                              | Create a new healthcare plan          |
| GET    | `/api/healthcare-plans/{id}`                         | Get a specific healthcare plan        |
| PUT    | `/api/healthcare-plans/{id}`                         | Update a healthcare plan              |
| DELETE | `/api/healthcare-plans/{id}`                         | Delete a healthcare plan              |
| GET    | `/api/healthcare-plans/coverage-type/{coverageType}` | Get healthcare plans by coverage type |
| GET    | `/api/healthcare-plans/active`                       | Get active healthcare plans           |
| GET    | `/api/healthcare-plans/provider/{provider}`          | Get healthcare plans by provider      |
| GET    | `/api/healthcare-plans/user/{userId}`                | Get healthcare plans for a user       |

## Monthly Payrolls

| Method | Endpoint                                          | Description                                   |
| ------ | ------------------------------------------------- | --------------------------------------------- |
| GET    | `/api/monthly-payrolls`                           | List all monthly payrolls                     |
| POST   | `/api/monthly-payrolls`                           | Create a new monthly payroll                  |
| GET    | `/api/monthly-payrolls/{id}`                      | Get a specific monthly payroll                |
| PUT    | `/api/monthly-payrolls/{id}`                      | Update a monthly payroll                      |
| DELETE | `/api/monthly-payrolls/{id}`                      | Delete a monthly payroll                      |
| GET    | `/api/monthly-payrolls/month-year/{month}/{year}` | Get payrolls for a specific month and year    |
| GET    | `/api/monthly-payrolls/user/{userId}`             | Get payrolls for a user                       |
| GET    | `/api/monthly-payrolls/status/{status}`           | Get payrolls by status                        |
| GET    | `/api/monthly-payrolls/department/{departmentId}` | Get payrolls for a department                 |
| POST   | `/api/monthly-payrolls/date-range`                | Get payrolls in a date range                  |
| GET    | `/api/monthly-payrolls/total/{month}/{year}`      | Get total payroll amount for a month and year |
| POST   | `/api/monthly-payrolls/{id}/approve`              | Approve a payroll                             |
| POST   | `/api/monthly-payrolls/{id}/mark-paid`            | Mark a payroll as paid                        |
| POST   | `/api/monthly-payrolls/{id}/cancel`               | Cancel a payroll                              |

## Attendances

| Method | Endpoint                         | Description                            |
| ------ | -------------------------------- | -------------------------------------- |
| GET    | `/api/attendances`               | List all attendance records            |
| POST   | `/api/attendances`               | Create a new attendance record         |
| GET    | `/api/attendances/{id}`          | Get a specific attendance record       |
| PUT    | `/api/attendances/{id}`          | Update an attendance record            |
| DELETE | `/api/attendances/{id}`          | Delete an attendance record            |
| GET    | `/api/attendances/user/{userId}` | Get attendance records for a user      |
| POST   | `/api/attendances/date-range`    | Get attendance records in a date range |

## Base Salaries

| Method | Endpoint                           | Description                  |
| ------ | ---------------------------------- | ---------------------------- |
| GET    | `/api/base-salaries`               | List all base salaries       |
| POST   | `/api/base-salaries`               | Create a new base salary     |
| GET    | `/api/base-salaries/{id}`          | Get a specific base salary   |
| PUT    | `/api/base-salaries/{id}`          | Update a base salary         |
| DELETE | `/api/base-salaries/{id}`          | Delete a base salary         |
| GET    | `/api/base-salaries/user/{userId}` | Get base salaries for a user |

## Benefit Plans

| Method | Endpoint                           | Description                  |
| ------ | ---------------------------------- | ---------------------------- |
| GET    | `/api/benefit-plans`               | List all benefit plans       |
| POST   | `/api/benefit-plans`               | Create a new benefit plan    |
| GET    | `/api/benefit-plans/{id}`          | Get a specific benefit plan  |
| PUT    | `/api/benefit-plans/{id}`          | Update a benefit plan        |
| DELETE | `/api/benefit-plans/{id}`          | Delete a benefit plan        |
| GET    | `/api/benefit-plans/user/{userId}` | Get benefit plans for a user |
| GET    | `/api/benefit-plans/active`        | Get active benefit plans     |

## Candidates

| Method | Endpoint                              | Description                   |
| ------ | ------------------------------------- | ----------------------------- |
| GET    | `/api/candidates`                     | List all candidates           |
| POST   | `/api/candidates`                     | Create a new candidate        |
| GET    | `/api/candidates/{id}`                | Get a specific candidate      |
| PUT    | `/api/candidates/{id}`                | Update a candidate            |
| DELETE | `/api/candidates/{id}`                | Delete a candidate            |
| GET    | `/api/candidates/position/{position}` | Get candidates for a position |
| GET    | `/api/candidates/status/{status}`     | Get candidates by status      |
| POST   | `/api/candidates/search`              | Search candidates             |

## Compliance

| Method | Endpoint                          | Description                       |
| ------ | --------------------------------- | --------------------------------- |
| GET    | `/api/compliance`                 | List all compliance records       |
| POST   | `/api/compliance`                 | Create a new compliance record    |
| GET    | `/api/compliance/{id}`            | Get a specific compliance record  |
| PUT    | `/api/compliance/{id}`            | Update a compliance record        |
| DELETE | `/api/compliance/{id}`            | Delete a compliance record        |
| GET    | `/api/compliance/user/{userId}`   | Get compliance records for a user |
| GET    | `/api/compliance/status/{status}` | Get compliance records by status  |
| GET    | `/api/compliance/type/{type}`     | Get compliance records by type    |
| GET    | `/api/compliance/expiring`        | Get expiring compliance records   |

## Documents

| Method | Endpoint                             | Description               |
| ------ | ------------------------------------ | ------------------------- |
| GET    | `/api/documents`                     | List all documents        |
| POST   | `/api/documents`                     | Upload a new document     |
| GET    | `/api/documents/{id}`                | Get a specific document   |
| PUT    | `/api/documents/{id}`                | Update a document         |
| DELETE | `/api/documents/{id}`                | Delete a document         |
| GET    | `/api/documents/user/{userId}`       | Get documents for a user  |
| GET    | `/api/documents/category/{category}` | Get documents by category |
| GET    | `/api/documents/type/{documentType}` | Get documents by type     |
| POST   | `/api/documents/search`              | Search documents          |

## Roles

| Method | Endpoint                | Description          |
| ------ | ----------------------- | -------------------- |
| GET    | `/api/roles`            | List all roles       |
| POST   | `/api/roles`            | Create a new role    |
| GET    | `/api/roles/{id}`       | Get a specific role  |
| PUT    | `/api/roles/{id}`       | Update a role        |
| DELETE | `/api/roles/{id}`       | Delete a role        |
| GET    | `/api/roles/{id}/tasks` | Get tasks for a role |

## Onboarding Tasks

| Method | Endpoint                                           | Description                          |
| ------ | -------------------------------------------------- | ------------------------------------ |
| GET    | `/api/onboarding-tasks`                            | List all onboarding tasks            |
| POST   | `/api/onboarding-tasks`                            | Create a new onboarding task         |
| GET    | `/api/onboarding-tasks/{id}`                       | Get a specific onboarding task       |
| PUT    | `/api/onboarding-tasks/{id}`                       | Update an onboarding task            |
| DELETE | `/api/onboarding-tasks/{id}`                       | Delete an onboarding task            |
| GET    | `/api/onboarding-tasks/employee/{employeeId}`      | Get onboarding tasks for an employee |
| GET    | `/api/onboarding-tasks/role/{roleId}`              | Get onboarding tasks for a role      |
| GET    | `/api/onboarding-tasks/roles`                      | List all roles for onboarding        |
| GET    | `/api/onboarding-tasks/roles/{id}`                 | Get a specific role for onboarding   |
| POST   | `/api/onboarding-tasks/roles`                      | Create a new role for onboarding     |
| PUT    | `/api/onboarding-tasks/roles/{id}`                 | Update a role for onboarding         |
| DELETE | `/api/onboarding-tasks/roles/{id}`                 | Delete a role for onboarding         |
| GET    | `/api/onboarding-tasks/roles/{roleId}/tasks`       | Get tasks for a specific role        |
| POST   | `/api/onboarding-tasks/roles/assign-task`          | Assign a task to a role              |
| POST   | `/api/onboarding-tasks/roles/remove-task`          | Remove a task from a role            |
| POST   | `/api/onboarding-tasks/employee/assign-role-tasks` | Assign role tasks to an employee     |

## Authorization

The API has three main user types with different access levels:

1. **Guest** (user type 0): Can only view jobs and limited information.
2. **Employee** (user type 1): Can access their own tasks, applications, documents, and benefit information.
3. **HR** (user type 2): Has full access to manage all aspects of the HR system including insurance plans, benefits, roles, and onboarding tasks.

Some routes are available to all authenticated users, while others are restricted by user type.

# HR-Nexus API Documentation

This document provides an overview of all available API endpoints in the HR-Nexus backend system.

## Authentication

| Method | Endpoint             | Description                                |
| ------ | -------------------- | ------------------------------------------ |
| POST   | `/api/auth/register` | Register a new user                        |
| POST   | `/api/auth/login`    | Login and get authentication token         |
| POST   | `/api/auth/logout`   | Logout (requires JWT)                      |
| POST   | `/api/auth/refresh`  | Refresh JWT token (requires JWT)           |
| GET    | `/api/auth/me`       | Get authenticated user info (requires JWT) |

## Users

| Method | Endpoint          | Description         |
| ------ | ----------------- | ------------------- |
| GET    | `/api/users`      | List all users      |
| POST   | `/api/users`      | Create a new user   |
| GET    | `/api/users/{id}` | Get a specific user |
| PUT    | `/api/users/{id}` | Update a user       |
| DELETE | `/api/users/{id}` | Delete a user       |

## Departments

| Method | Endpoint                | Description               |
| ------ | ----------------------- | ------------------------- |
| GET    | `/api/departments`      | List all departments      |
| POST   | `/api/departments`      | Create a new department   |
| GET    | `/api/departments/{id}` | Get a specific department |
| PUT    | `/api/departments/{id}` | Update a department       |
| DELETE | `/api/departments/{id}` | Delete a department       |

## Jobs

| Method | Endpoint                            | Description               |
| ------ | ----------------------------------- | ------------------------- |
| GET    | `/api/jobs`                         | List all jobs (public)    |
| POST   | `/api/jobs`                         | Create a new job          |
| GET    | `/api/jobs/{id}`                    | Get a specific job        |
| PUT    | `/api/jobs/{id}`                    | Update a job              |
| DELETE | `/api/jobs/{id}`                    | Delete a job              |
| GET    | `/api/jobs/status/{status}`         | Get jobs by status        |
| GET    | `/api/jobs/department/{department}` | Get jobs by department    |
| GET    | `/api/jobs/type/{jobType}`          | Get jobs by type          |
| GET    | `/api/jobs/active`                  | Get active jobs           |
| GET    | `/api/jobs/location/{location}`     | Get jobs by location      |
| GET    | `/api/jobs/remote/{isRemote}`       | Get jobs by remote status |
| POST   | `/api/jobs/search`                  | Search jobs               |

## Job Applications

| Method | Endpoint                                | Description                           |
| ------ | --------------------------------------- | ------------------------------------- |
| GET    | `/api/job-applications`                 | List all job applications             |
| POST   | `/api/job-applications`                 | Create a job application              |
| GET    | `/api/job-applications/{id}`            | Get a specific job application        |
| PUT    | `/api/job-applications/{id}`            | Update a job application              |
| DELETE | `/api/job-applications/{id}`            | Delete a job application              |
| GET    | `/api/job-applications/job/{jobId}`     | Get applications for a specific job   |
| GET    | `/api/job-applications/user/{userId}`   | Get applications from a specific user |
| GET    | `/api/job-applications/status/{status}` | Get applications by status            |
| POST   | `/api/job-applications/date-range`      | Get applications in a date range      |
| GET    | `/api/job-applications/recent/{days?}`  | Get recent applications               |

## Tasks

| Method | Endpoint                         | Description                  |
| ------ | -------------------------------- | ---------------------------- |
| GET    | `/api/tasks`                     | List all tasks               |
| POST   | `/api/tasks`                     | Create a new task            |
| GET    | `/api/tasks/{id}`                | Get a specific task          |
| PUT    | `/api/tasks/{id}`                | Update a task                |
| DELETE | `/api/tasks/{id}`                | Delete a task                |
| GET    | `/api/tasks/status/{status}`     | Get tasks by status          |
| GET    | `/api/tasks/priority/{priority}` | Get tasks by priority        |
| GET    | `/api/tasks/user/{userId}`       | Get tasks assigned to a user |
| GET    | `/api/tasks/upcoming/{days?}`    | Get upcoming tasks           |

## HR Projects

| Method | Endpoint                               | Description                      |
| ------ | -------------------------------------- | -------------------------------- |
| GET    | `/api/hr-projects`                     | List all HR projects             |
| POST   | `/api/hr-projects`                     | Create a new HR project          |
| GET    | `/api/hr-projects/{id}`                | Get a specific HR project        |
| PUT    | `/api/hr-projects/{id}`                | Update an HR project             |
| DELETE | `/api/hr-projects/{id}`                | Delete an HR project             |
| GET    | `/api/hr-projects/user/{userId}`       | Get HR projects by assigned user |
| GET    | `/api/hr-projects/status/{status}`     | Get HR projects by status        |
| GET    | `/api/hr-projects/priority/{priority}` | Get HR projects by priority      |
| GET    | `/api/hr-projects/upcoming/{days?}`    | Get upcoming HR projects         |

## HR Project Tasks

| Method | Endpoint                                          | Description                      |
| ------ | ------------------------------------------------- | -------------------------------- |
| GET    | `/api/hr-project-tasks`                           | List all HR project tasks        |
| POST   | `/api/hr-project-tasks`                           | Create a new HR project task     |
| GET    | `/api/hr-project-tasks/{id}`                      | Get a specific HR project task   |
| DELETE | `/api/hr-project-tasks/{id}`                      | Delete an HR project task        |
| GET    | `/api/hr-project-tasks/project/{projectId}/tasks` | Get tasks for a specific project |
| GET    | `/api/hr-project-tasks/task/{taskId}/projects`    | Get projects for a specific task |

## Insurance Plans

| Method | Endpoint                                   | Description                     |
| ------ | ------------------------------------------ | ------------------------------- |
| GET    | `/api/insurance-plans`                     | List all insurance plans        |
| POST   | `/api/insurance-plans`                     | Create a new insurance plan     |
| GET    | `/api/insurance-plans/{id}`                | Get a specific insurance plan   |
| PUT    | `/api/insurance-plans/{id}`                | Update an insurance plan        |
| DELETE | `/api/insurance-plans/{id}`                | Delete an insurance plan        |
| GET    | `/api/insurance-plans/type/{type}`         | Get insurance plans by type     |
| GET    | `/api/insurance-plans/status/{status}`     | Get insurance plans by status   |
| GET    | `/api/insurance-plans/provider/{provider}` | Get insurance plans by provider |
| GET    | `/api/insurance-plans/active`              | Get active insurance plans      |
| GET    | `/api/insurance-plans/user/{userId}`       | Get insurance plans for a user  |

## Health Care Plans

| Method | Endpoint                                             | Description                           |
| ------ | ---------------------------------------------------- | ------------------------------------- |
| GET    | `/api/healthcare-plans`                              | List all healthcare plans             |
| POST   | `/api/healthcare-plans`                              | Create a new healthcare plan          |
| GET    | `/api/healthcare-plans/{id}`                         | Get a specific healthcare plan        |
| PUT    | `/api/healthcare-plans/{id}`                         | Update a healthcare plan              |
| DELETE | `/api/healthcare-plans/{id}`                         | Delete a healthcare plan              |
| GET    | `/api/healthcare-plans/coverage-type/{coverageType}` | Get healthcare plans by coverage type |
| GET    | `/api/healthcare-plans/active`                       | Get active healthcare plans           |
| GET    | `/api/healthcare-plans/provider/{provider}`          | Get healthcare plans by provider      |
| GET    | `/api/healthcare-plans/user/{userId}`                | Get healthcare plans for a user       |

## Monthly Payrolls

| Method | Endpoint                                          | Description                                   |
| ------ | ------------------------------------------------- | --------------------------------------------- |
| GET    | `/api/monthly-payrolls`                           | List all monthly payrolls                     |
| POST   | `/api/monthly-payrolls`                           | Create a new monthly payroll                  |
| GET    | `/api/monthly-payrolls/{id}`                      | Get a specific monthly payroll                |
| PUT    | `/api/monthly-payrolls/{id}`                      | Update a monthly payroll                      |
| DELETE | `/api/monthly-payrolls/{id}`                      | Delete a monthly payroll                      |
| GET    | `/api/monthly-payrolls/month-year/{month}/{year}` | Get payrolls for a specific month and year    |
| GET    | `/api/monthly-payrolls/user/{userId}`             | Get payrolls for a user                       |
| GET    | `/api/monthly-payrolls/status/{status}`           | Get payrolls by status                        |
| GET    | `/api/monthly-payrolls/department/{departmentId}` | Get payrolls for a department                 |
| POST   | `/api/monthly-payrolls/date-range`                | Get payrolls in a date range                  |
| GET    | `/api/monthly-payrolls/total/{month}/{year}`      | Get total payroll amount for a month and year |
| POST   | `/api/monthly-payrolls/{id}/approve`              | Approve a payroll                             |
| POST   | `/api/monthly-payrolls/{id}/mark-paid`            | Mark a payroll as paid                        |
| POST   | `/api/monthly-payrolls/{id}/cancel`               | Cancel a payroll                              |

## Attendances

| Method | Endpoint                         | Description                            |
| ------ | -------------------------------- | -------------------------------------- |
| GET    | `/api/attendances`               | List all attendance records            |
| POST   | `/api/attendances`               | Create a new attendance record         |
| GET    | `/api/attendances/{id}`          | Get a specific attendance record       |
| PUT    | `/api/attendances/{id}`          | Update an attendance record            |
| DELETE | `/api/attendances/{id}`          | Delete an attendance record            |
| GET    | `/api/attendances/user/{userId}` | Get attendance records for a user      |
| POST   | `/api/attendances/date-range`    | Get attendance records in a date range |

## Base Salaries

| Method | Endpoint                           | Description                  |
| ------ | ---------------------------------- | ---------------------------- |
| GET    | `/api/base-salaries`               | List all base salaries       |
| POST   | `/api/base-salaries`               | Create a new base salary     |
| GET    | `/api/base-salaries/{id}`          | Get a specific base salary   |
| PUT    | `/api/base-salaries/{id}`          | Update a base salary         |
| DELETE | `/api/base-salaries/{id}`          | Delete a base salary         |
| GET    | `/api/base-salaries/user/{userId}` | Get base salaries for a user |

## Benefit Plans

| Method | Endpoint                           | Description                  |
| ------ | ---------------------------------- | ---------------------------- |
| GET    | `/api/benefit-plans`               | List all benefit plans       |
| POST   | `/api/benefit-plans`               | Create a new benefit plan    |
| GET    | `/api/benefit-plans/{id}`          | Get a specific benefit plan  |
| PUT    | `/api/benefit-plans/{id}`          | Update a benefit plan        |
| DELETE | `/api/benefit-plans/{id}`          | Delete a benefit plan        |
| GET    | `/api/benefit-plans/user/{userId}` | Get benefit plans for a user |
| GET    | `/api/benefit-plans/active`        | Get active benefit plans     |

## Candidates

| Method | Endpoint                              | Description                   |
| ------ | ------------------------------------- | ----------------------------- |
| GET    | `/api/candidates`                     | List all candidates           |
| POST   | `/api/candidates`                     | Create a new candidate        |
| GET    | `/api/candidates/{id}`                | Get a specific candidate      |
| PUT    | `/api/candidates/{id}`                | Update a candidate            |
| DELETE | `/api/candidates/{id}`                | Delete a candidate            |
| GET    | `/api/candidates/position/{position}` | Get candidates for a position |
| GET    | `/api/candidates/status/{status}`     | Get candidates by status      |
| POST   | `/api/candidates/search`              | Search candidates             |

## Compliance

| Method | Endpoint                          | Description                       |
| ------ | --------------------------------- | --------------------------------- |
| GET    | `/api/compliance`                 | List all compliance records       |
| POST   | `/api/compliance`                 | Create a new compliance record    |
| GET    | `/api/compliance/{id}`            | Get a specific compliance record  |
| PUT    | `/api/compliance/{id}`            | Update a compliance record        |
| DELETE | `/api/compliance/{id}`            | Delete a compliance record        |
| GET    | `/api/compliance/user/{userId}`   | Get compliance records for a user |
| GET    | `/api/compliance/status/{status}` | Get compliance records by status  |
| GET    | `/api/compliance/type/{type}`     | Get compliance records by type    |
| GET    | `/api/compliance/expiring`        | Get expiring compliance records   |

## Documents

| Method | Endpoint                             | Description               |
| ------ | ------------------------------------ | ------------------------- |
| GET    | `/api/documents`                     | List all documents        |
| POST   | `/api/documents`                     | Upload a new document     |
| GET    | `/api/documents/{id}`                | Get a specific document   |
| PUT    | `/api/documents/{id}`                | Update a document         |
| DELETE | `/api/documents/{id}`                | Delete a document         |
| GET    | `/api/documents/user/{userId}`       | Get documents for a user  |
| GET    | `/api/documents/category/{category}` | Get documents by category |
| GET    | `/api/documents/type/{documentType}` | Get documents by type     |
| POST   | `/api/documents/search`              | Search documents          |

## Roles

| Method | Endpoint                | Description          |
| ------ | ----------------------- | -------------------- |
| GET    | `/api/roles`            | List all roles       |
| POST   | `/api/roles`            | Create a new role    |
| GET    | `/api/roles/{id}`       | Get a specific role  |
| PUT    | `/api/roles/{id}`       | Update a role        |
| DELETE | `/api/roles/{id}`       | Delete a role        |
| GET    | `/api/roles/{id}/tasks` | Get tasks for a role |

## Onboarding Tasks

| Method | Endpoint                                           | Description                          |
| ------ | -------------------------------------------------- | ------------------------------------ |
| GET    | `/api/onboarding-tasks`                            | List all onboarding tasks            |
| POST   | `/api/onboarding-tasks`                            | Create a new onboarding task         |
| GET    | `/api/onboarding-tasks/{id}`                       | Get a specific onboarding task       |
| PUT    | `/api/onboarding-tasks/{id}`                       | Update an onboarding task            |
| DELETE | `/api/onboarding-tasks/{id}`                       | Delete an onboarding task            |
| GET    | `/api/onboarding-tasks/employee/{employeeId}`      | Get onboarding tasks for an employee |
| GET    | `/api/onboarding-tasks/role/{roleId}`              | Get onboarding tasks for a role      |
| GET    | `/api/onboarding-tasks/roles`                      | List all roles for onboarding        |
| GET    | `/api/onboarding-tasks/roles/{id}`                 | Get a specific role for onboarding   |
| POST   | `/api/onboarding-tasks/roles`                      | Create a new role for onboarding     |
| PUT    | `/api/onboarding-tasks/roles/{id}`                 | Update a role for onboarding         |
| DELETE | `/api/onboarding-tasks/roles/{id}`                 | Delete a role for onboarding         |
| GET    | `/api/onboarding-tasks/roles/{roleId}/tasks`       | Get tasks for a specific role        |
| POST   | `/api/onboarding-tasks/roles/assign-task`          | Assign a task to a role              |
| POST   | `/api/onboarding-tasks/roles/remove-task`          | Remove a task from a role            |
| POST   | `/api/onboarding-tasks/employee/assign-role-tasks` | Assign role tasks to an employee     |

## Authorization

The API has three main user types with different access levels:

1. **Guest** (user type 0): Can only view jobs and limited information.
2. **Employee** (user type 1): Can access their own tasks, applications, documents, and benefit information.
3. **HR** (user type 2): Has full access to manage all aspects of the HR system including insurance plans, benefits, roles, and onboarding tasks.

Some routes are available to all authenticated users, while others are restricted by user type.

# HR-Nexus API Documentation

This document provides an overview of all available API endpoints in the HR-Nexus backend system.

## Authentication

| Method | Endpoint             | Description                                |
| ------ | -------------------- | ------------------------------------------ |
| POST   | `/api/auth/register` | Register a new user                        |
| POST   | `/api/auth/login`    | Login and get authentication token         |
| POST   | `/api/auth/logout`   | Logout (requires JWT)                      |
| POST   | `/api/auth/refresh`  | Refresh JWT token (requires JWT)           |
| GET    | `/api/auth/me`       | Get authenticated user info (requires JWT) |

## Users

| Method | Endpoint          | Description         |
| ------ | ----------------- | ------------------- |
| GET    | `/api/users`      | List all users      |
| POST   | `/api/users`      | Create a new user   |
| GET    | `/api/users/{id}` | Get a specific user |
| PUT    | `/api/users/{id}` | Update a user       |
| DELETE | `/api/users/{id}` | Delete a user       |

## Departments

| Method | Endpoint                | Description               |
| ------ | ----------------------- | ------------------------- |
| GET    | `/api/departments`      | List all departments      |
| POST   | `/api/departments`      | Create a new department   |
| GET    | `/api/departments/{id}` | Get a specific department |
| PUT    | `/api/departments/{id}` | Update a department       |
| DELETE | `/api/departments/{id}` | Delete a department       |

## Jobs

| Method | Endpoint                            | Description               |
| ------ | ----------------------------------- | ------------------------- |
| GET    | `/api/jobs`                         | List all jobs (public)    |
| POST   | `/api/jobs`                         | Create a new job          |
| GET    | `/api/jobs/{id}`                    | Get a specific job        |
| PUT    | `/api/jobs/{id}`                    | Update a job              |
| DELETE | `/api/jobs/{id}`                    | Delete a job              |
| GET    | `/api/jobs/status/{status}`         | Get jobs by status        |
| GET    | `/api/jobs/department/{department}` | Get jobs by department    |
| GET    | `/api/jobs/type/{jobType}`          | Get jobs by type          |
| GET    | `/api/jobs/active`                  | Get active jobs           |
| GET    | `/api/jobs/location/{location}`     | Get jobs by location      |
| GET    | `/api/jobs/remote/{isRemote}`       | Get jobs by remote status |
| POST   | `/api/jobs/search`                  | Search jobs               |

## Job Applications

| Method | Endpoint                                | Description                           |
| ------ | --------------------------------------- | ------------------------------------- |
| GET    | `/api/job-applications`                 | List all job applications             |
| POST   | `/api/job-applications`                 | Create a job application              |
| GET    | `/api/job-applications/{id}`            | Get a specific job application        |
| PUT    | `/api/job-applications/{id}`            | Update a job application              |
| DELETE | `/api/job-applications/{id}`            | Delete a job application              |
| GET    | `/api/job-applications/job/{jobId}`     | Get applications for a specific job   |
| GET    | `/api/job-applications/user/{userId}`   | Get applications from a specific user |
| GET    | `/api/job-applications/status/{status}` | Get applications by status            |
| POST   | `/api/job-applications/date-range`      | Get applications in a date range      |
| GET    | `/api/job-applications/recent/{days?}`  | Get recent applications               |

## Tasks

| Method | Endpoint                         | Description                  |
| ------ | -------------------------------- | ---------------------------- |
| GET    | `/api/tasks`                     | List all tasks               |
| POST   | `/api/tasks`                     | Create a new task            |
| GET    | `/api/tasks/{id}`                | Get a specific task          |
| PUT    | `/api/tasks/{id}`                | Update a task                |
| DELETE | `/api/tasks/{id}`                | Delete a task                |
| GET    | `/api/tasks/status/{status}`     | Get tasks by status          |
| GET    | `/api/tasks/priority/{priority}` | Get tasks by priority        |
| GET    | `/api/tasks/user/{userId}`       | Get tasks assigned to a user |
| GET    | `/api/tasks/upcoming/{days?}`    | Get upcoming tasks           |

## HR Projects

| Method | Endpoint                               | Description                      |
| ------ | -------------------------------------- | -------------------------------- |
| GET    | `/api/hr-projects`                     | List all HR projects             |
| POST   | `/api/hr-projects`                     | Create a new HR project          |
| GET    | `/api/hr-projects/{id}`                | Get a specific HR project        |
| PUT    | `/api/hr-projects/{id}`                | Update an HR project             |
| DELETE | `/api/hr-projects/{id}`                | Delete an HR project             |
| GET    | `/api/hr-projects/user/{userId}`       | Get HR projects by assigned user |
| GET    | `/api/hr-projects/status/{status}`     | Get HR projects by status        |
| GET    | `/api/hr-projects/priority/{priority}` | Get HR projects by priority      |
| GET    | `/api/hr-projects/upcoming/{days?}`    | Get upcoming HR projects         |

## HR Project Tasks

| Method | Endpoint                                          | Description                      |
| ------ | ------------------------------------------------- | -------------------------------- |
| GET    | `/api/hr-project-tasks`                           | List all HR project tasks        |
| POST   | `/api/hr-project-tasks`                           | Create a new HR project task     |
| GET    | `/api/hr-project-tasks/{id}`                      | Get a specific HR project task   |
| DELETE | `/api/hr-project-tasks/{id}`                      | Delete an HR project task        |
| GET    | `/api/hr-project-tasks/project/{projectId}/tasks` | Get tasks for a specific project |
| GET    | `/api/hr-project-tasks/task/{taskId}/projects`    | Get projects for a specific task |

## Insurance Plans

| Method | Endpoint                                   | Description                     |
| ------ | ------------------------------------------ | ------------------------------- |
| GET    | `/api/insurance-plans`                     | List all insurance plans        |
| POST   | `/api/insurance-plans`                     | Create a new insurance plan     |
| GET    | `/api/insurance-plans/{id}`                | Get a specific insurance plan   |
| PUT    | `/api/insurance-plans/{id}`                | Update an insurance plan        |
| DELETE | `/api/insurance-plans/{id}`                | Delete an insurance plan        |
| GET    | `/api/insurance-plans/type/{type}`         | Get insurance plans by type     |
| GET    | `/api/insurance-plans/status/{status}`     | Get insurance plans by status   |
| GET    | `/api/insurance-plans/provider/{provider}` | Get insurance plans by provider |
| GET    | `/api/insurance-plans/active`              | Get active insurance plans      |
| GET    | `/api/insurance-plans/user/{userId}`       | Get insurance plans for a user  |

## Health Care Plans

| Method | Endpoint                                             | Description                           |
| ------ | ---------------------------------------------------- | ------------------------------------- |
| GET    | `/api/healthcare-plans`                              | List all healthcare plans             |
| POST   | `/api/healthcare-plans`                              | Create a new healthcare plan          |
| GET    | `/api/healthcare-plans/{id}`                         | Get a specific healthcare plan        |
| PUT    | `/api/healthcare-plans/{id}`                         | Update a healthcare plan              |
| DELETE | `/api/healthcare-plans/{id}`                         | Delete a healthcare plan              |
| GET    | `/api/healthcare-plans/coverage-type/{coverageType}` | Get healthcare plans by coverage type |
| GET    | `/api/healthcare-plans/active`                       | Get active healthcare plans           |
| GET    | `/api/healthcare-plans/provider/{provider}`          | Get healthcare plans by provider      |
| GET    | `/api/healthcare-plans/user/{userId}`                | Get healthcare plans for a user       |

## Monthly Payrolls

| Method | Endpoint                                          | Description                                   |
| ------ | ------------------------------------------------- | --------------------------------------------- |
| GET    | `/api/monthly-payrolls`                           | List all monthly payrolls                     |
| POST   | `/api/monthly-payrolls`                           | Create a new monthly payroll                  |
| GET    | `/api/monthly-payrolls/{id}`                      | Get a specific monthly payroll                |
| PUT    | `/api/monthly-payrolls/{id}`                      | Update a monthly payroll                      |
| DELETE | `/api/monthly-payrolls/{id}`                      | Delete a monthly payroll                      |
| GET    | `/api/monthly-payrolls/month-year/{month}/{year}` | Get payrolls for a specific month and year    |
| GET    | `/api/monthly-payrolls/user/{userId}`             | Get payrolls for a user                       |
| GET    | `/api/monthly-payrolls/status/{status}`           | Get payrolls by status                        |
| GET    | `/api/monthly-payrolls/department/{departmentId}` | Get payrolls for a department                 |
| POST   | `/api/monthly-payrolls/date-range`                | Get payrolls in a date range                  |
| GET    | `/api/monthly-payrolls/total/{month}/{year}`      | Get total payroll amount for a month and year |
| POST   | `/api/monthly-payrolls/{id}/approve`              | Approve a payroll                             |
| POST   | `/api/monthly-payrolls/{id}/mark-paid`            | Mark a payroll as paid                        |
| POST   | `/api/monthly-payrolls/{id}/cancel`               | Cancel a payroll                              |

## Attendances

| Method | Endpoint                         | Description                            |
| ------ | -------------------------------- | -------------------------------------- |
| GET    | `/api/attendances`               | List all attendance records            |
| POST   | `/api/attendances`               | Create a new attendance record         |
| GET    | `/api/attendances/{id}`          | Get a specific attendance record       |
| PUT    | `/api/attendances/{id}`          | Update an attendance record            |
| DELETE | `/api/attendances/{id}`          | Delete an attendance record            |
| GET    | `/api/attendances/user/{userId}` | Get attendance records for a user      |
| POST   | `/api/attendances/date-range`    | Get attendance records in a date range |

## Base Salaries

| Method | Endpoint                           | Description                  |
| ------ | ---------------------------------- | ---------------------------- |
| GET    | `/api/base-salaries`               | List all base salaries       |
| POST   | `/api/base-salaries`               | Create a new base salary     |
| GET    | `/api/base-salaries/{id}`          | Get a specific base salary   |
| PUT    | `/api/base-salaries/{id}`          | Update a base salary         |
| DELETE | `/api/base-salaries/{id}`          | Delete a base salary         |
| GET    | `/api/base-salaries/user/{userId}` | Get base salaries for a user |

## Benefit Plans

| Method | Endpoint                           | Description                  |
| ------ | ---------------------------------- | ---------------------------- |
| GET    | `/api/benefit-plans`               | List all benefit plans       |
| POST   | `/api/benefit-plans`               | Create a new benefit plan    |
| GET    | `/api/benefit-plans/{id}`          | Get a specific benefit plan  |
| PUT    | `/api/benefit-plans/{id}`          | Update a benefit plan        |
| DELETE | `/api/benefit-plans/{id}`          | Delete a benefit plan        |
| GET    | `/api/benefit-plans/user/{userId}` | Get benefit plans for a user |
| GET    | `/api/benefit-plans/active`        | Get active benefit plans     |

## Candidates

| Method | Endpoint                              | Description                   |
| ------ | ------------------------------------- | ----------------------------- |
| GET    | `/api/candidates`                     | List all candidates           |
| POST   | `/api/candidates`                     | Create a new candidate        |
| GET    | `/api/candidates/{id}`                | Get a specific candidate      |
| PUT    | `/api/candidates/{id}`                | Update a candidate            |
| DELETE | `/api/candidates/{id}`                | Delete a candidate            |
| GET    | `/api/candidates/position/{position}` | Get candidates for a position |
| GET    | `/api/candidates/status/{status}`     | Get candidates by status      |
| POST   | `/api/candidates/search`              | Search candidates             |

## Compliance

| Method | Endpoint                          | Description                       |
| ------ | --------------------------------- | --------------------------------- |
| GET    | `/api/compliance`                 | List all compliance records       |
| POST   | `/api/compliance`                 | Create a new compliance record    |
| GET    | `/api/compliance/{id}`            | Get a specific compliance record  |
| PUT    | `/api/compliance/{id}`            | Update a compliance record        |
| DELETE | `/api/compliance/{id}`            | Delete a compliance record        |
| GET    | `/api/compliance/user/{userId}`   | Get compliance records for a user |
| GET    | `/api/compliance/status/{status}` | Get compliance records by status  |
| GET    | `/api/compliance/type/{type}`     | Get compliance records by type    |
| GET    | `/api/compliance/expiring`        | Get expiring compliance records   |

## Documents

| Method | Endpoint                             | Description               |
| ------ | ------------------------------------ | ------------------------- |
| GET    | `/api/documents`                     | List all documents        |
| POST   | `/api/documents`                     | Upload a new document     |
| GET    | `/api/documents/{id}`                | Get a specific document   |
| PUT    | `/api/documents/{id}`                | Update a document         |
| DELETE | `/api/documents/{id}`                | Delete a document         |
| GET    | `/api/documents/user/{userId}`       | Get documents for a user  |
| GET    | `/api/documents/category/{category}` | Get documents by category |
| GET    | `/api/documents/type/{documentType}` | Get documents by type     |
| POST   | `/api/documents/search`              | Search documents          |

## Roles

| Method | Endpoint                | Description          |
| ------ | ----------------------- | -------------------- |
| GET    | `/api/roles`            | List all roles       |
| POST   | `/api/roles`            | Create a new role    |
| GET    | `/api/roles/{id}`       | Get a specific role  |
| PUT    | `/api/roles/{id}`       | Update a role        |
| DELETE | `/api/roles/{id}`       | Delete a role        |
| GET    | `/api/roles/{id}/tasks` | Get tasks for a role |

## Onboarding Tasks

| Method | Endpoint                                           | Description                          |
| ------ | -------------------------------------------------- | ------------------------------------ |
| GET    | `/api/onboarding-tasks`                            | List all onboarding tasks            |
| POST   | `/api/onboarding-tasks`                            | Create a new onboarding task         |
| GET    | `/api/onboarding-tasks/{id}`                       | Get a specific onboarding task       |
| PUT    | `/api/onboarding-tasks/{id}`                       | Update an onboarding task            |
| DELETE | `/api/onboarding-tasks/{id}`                       | Delete an onboarding task            |
| GET    | `/api/onboarding-tasks/employee/{employeeId}`      | Get onboarding tasks for an employee |
| GET    | `/api/onboarding-tasks/role/{roleId}`              | Get onboarding tasks for a role      |
| GET    | `/api/onboarding-tasks/roles`                      | List all roles for onboarding        |
| GET    | `/api/onboarding-tasks/roles/{id}`                 | Get a specific role for onboarding   |
| POST   | `/api/onboarding-tasks/roles`                      | Create a new role for onboarding     |
| PUT    | `/api/onboarding-tasks/roles/{id}`                 | Update a role for onboarding         |
| DELETE | `/api/onboarding-tasks/roles/{id}`                 | Delete a role for onboarding         |
| GET    | `/api/onboarding-tasks/roles/{roleId}/tasks`       | Get tasks for a specific role        |
| POST   | `/api/onboarding-tasks/roles/assign-task`          | Assign a task to a role              |
| POST   | `/api/onboarding-tasks/roles/remove-task`          | Remove a task from a role            |
| POST   | `/api/onboarding-tasks/employee/assign-role-tasks` | Assign role tasks to an employee     |

## Authorization

The API has three main user types with different access levels:

1. **Guest** (user type 0): Can only view jobs and limited information.
2. **Employee** (user type 1): Can access their own tasks, applications, documents, and benefit information.
3. **HR** (user type 2): Has full access to manage all aspects of the HR system including insurance plans, benefits, roles, and onboarding tasks.

Some routes are available to all authenticated users, while others are restricted by user type.

# HR-Nexus API Documentation

This document provides an overview of all available API endpoints in the HR-Nexus backend system.

## Authentication

| Method | Endpoint             | Description                                |
| ------ | -------------------- | ------------------------------------------ |
| POST   | `/api/auth/register` | Register a new user                        |
| POST   | `/api/auth/login`    | Login and get authentication token         |
| POST   | `/api/auth/logout`   | Logout (requires JWT)                      |
| POST   | `/api/auth/refresh`  | Refresh JWT token (requires JWT)           |
| GET    | `/api/auth/me`       | Get authenticated user info (requires JWT) |

## Users

| Method | Endpoint          | Description         |
| ------ | ----------------- | ------------------- |
| GET    | `/api/users`      | List all users      |
| POST   | `/api/users`      | Create a new user   |
| GET    | `/api/users/{id}` | Get a specific user |
| PUT    | `/api/users/{id}` | Update a user       |
| DELETE | `/api/users/{id}` | Delete a user       |

## Departments

| Method | Endpoint                | Description               |
| ------ | ----------------------- | ------------------------- |
| GET    | `/api/departments`      | List all departments      |
| POST   | `/api/departments`      | Create a new department   |
| GET    | `/api/departments/{id}` | Get a specific department |
| PUT    | `/api/departments/{id}` | Update a department       |
| DELETE | `/api/departments/{id}` | Delete a department       |

## Jobs

| Method | Endpoint                            | Description               |
| ------ | ----------------------------------- | ------------------------- |
| GET    | `/api/jobs`                         | List all jobs (public)    |
| POST   | `/api/jobs`                         | Create a new job          |
| GET    | `/api/jobs/{id}`                    | Get a specific job        |
| PUT    | `/api/jobs/{id}`                    | Update a job              |
| DELETE | `/api/jobs/{id}`                    | Delete a job              |
| GET    | `/api/jobs/status/{status}`         | Get jobs by status        |
| GET    | `/api/jobs/department/{department}` | Get jobs by department    |
| GET    | `/api/jobs/type/{jobType}`          | Get jobs by type          |
| GET    | `/api/jobs/active`                  | Get active jobs           |
| GET    | `/api/jobs/location/{location}`     | Get jobs by location      |
| GET    | `/api/jobs/remote/{isRemote}`       | Get jobs by remote status |
| POST   | `/api/jobs/search`                  | Search jobs               |

## Job Applications

| Method | Endpoint                                | Description                           |
| ------ | --------------------------------------- | ------------------------------------- |
| GET    | `/api/job-applications`                 | List all job applications             |
| POST   | `/api/job-applications`                 | Create a job application              |
| GET    | `/api/job-applications/{id}`            | Get a specific job application        |
| PUT    | `/api/job-applications/{id}`            | Update a job application              |
| DELETE | `/api/job-applications/{id}`            | Delete a job application              |
| GET    | `/api/job-applications/job/{jobId}`     | Get applications for a specific job   |
| GET    | `/api/job-applications/user/{userId}`   | Get applications from a specific user |
| GET    | `/api/job-applications/status/{status}` | Get applications by status            |
| POST   | `/api/job-applications/date-range`      | Get applications in a date range      |
| GET    | `/api/job-applications/recent/{days?}`  | Get recent applications               |

## Tasks

| Method | Endpoint                         | Description                  |
| ------ | -------------------------------- | ---------------------------- |
| GET    | `/api/tasks`                     | List all tasks               |
| POST   | `/api/tasks`                     | Create a new task            |
| GET    | `/api/tasks/{id}`                | Get a specific task          |
| PUT    | `/api/tasks/{id}`                | Update a task                |
| DELETE | `/api/tasks/{id}`                | Delete a task                |
| GET    | `/api/tasks/status/{status}`     | Get tasks by status          |
| GET    | `/api/tasks/priority/{priority}` | Get tasks by priority        |
| GET    | `/api/tasks/user/{userId}`       | Get tasks assigned to a user |
| GET    | `/api/tasks/upcoming/{days?}`    | Get upcoming tasks           |

## HR Projects

| Method | Endpoint                               | Description                      |
| ------ | -------------------------------------- | -------------------------------- |
| GET    | `/api/hr-projects`                     | List all HR projects             |
| POST   | `/api/hr-projects`                     | Create a new HR project          |
| GET    | `/api/hr-projects/{id}`                | Get a specific HR project        |
| PUT    | `/api/hr-projects/{id}`                | Update an HR project             |
| DELETE | `/api/hr-projects/{id}`                | Delete an HR project             |
| GET    | `/api/hr-projects/user/{userId}`       | Get HR projects by assigned user |
| GET    | `/api/hr-projects/status/{status}`     | Get HR projects by status        |
| GET    | `/api/hr-projects/priority/{priority}` | Get HR projects by priority      |
| GET    | `/api/hr-projects/upcoming/{days?}`    | Get upcoming HR projects         |

## HR Project Tasks

| Method | Endpoint                                          | Description                      |
| ------ | ------------------------------------------------- | -------------------------------- |
| GET    | `/api/hr-project-tasks`                           | List all HR project tasks        |
| POST   | `/api/hr-project-tasks`                           | Create a new HR project task     |
| GET    | `/api/hr-project-tasks/{id}`                      | Get a specific HR project task   |
| DELETE | `/api/hr-project-tasks/{id}`                      | Delete an HR project task        |
| GET    | `/api/hr-project-tasks/project/{projectId}/tasks` | Get tasks for a specific project |
| GET    | `/api/hr-project-tasks/task/{taskId}/projects`    | Get projects for a specific task |

## Insurance Plans

| Method | Endpoint                                   | Description                     |
| ------ | ------------------------------------------ | ------------------------------- |
| GET    | `/api/insurance-plans`                     | List all insurance plans        |
| POST   | `/api/insurance-plans`                     | Create a new insurance plan     |
| GET    | `/api/insurance-plans/{id}`                | Get a specific insurance plan   |
| PUT    | `/api/insurance-plans/{id}`                | Update an insurance plan        |
| DELETE | `/api/insurance-plans/{id}`                | Delete an insurance plan        |
| GET    | `/api/insurance-plans/type/{type}`         | Get insurance plans by type     |
| GET    | `/api/insurance-plans/status/{status}`     | Get insurance plans by status   |
| GET    | `/api/insurance-plans/provider/{provider}` | Get insurance plans by provider |
| GET    | `/api/insurance-plans/active`              | Get active insurance plans      |
| GET    | `/api/insurance-plans/user/{userId}`       | Get insurance plans for a user  |

## Health Care Plans

| Method | Endpoint                                             | Description                           |
| ------ | ---------------------------------------------------- | ------------------------------------- |
| GET    | `/api/healthcare-plans`                              | List all healthcare plans             |
| POST   | `/api/healthcare-plans`                              | Create a new healthcare plan          |
| GET    | `/api/healthcare-plans/{id}`                         | Get a specific healthcare plan        |
| PUT    | `/api/healthcare-plans/{id}`                         | Update a healthcare plan              |
| DELETE | `/api/healthcare-plans/{id}`                         | Delete a healthcare plan              |
| GET    | `/api/healthcare-plans/coverage-type/{coverageType}` | Get healthcare plans by coverage type |
| GET    | `/api/healthcare-plans/active`                       | Get active healthcare plans           |
| GET    | `/api/healthcare-plans/provider/{provider}`          | Get healthcare plans by provider      |
| GET    | `/api/healthcare-plans/user/{userId}`                | Get healthcare plans for a user       |

## Monthly Payrolls

| Method | Endpoint                                          | Description                                   |
| ------ | ------------------------------------------------- | --------------------------------------------- |
| GET    | `/api/monthly-payrolls`                           | List all monthly payrolls                     |
| POST   | `/api/monthly-payrolls`                           | Create a new monthly payroll                  |
| GET    | `/api/monthly-payrolls/{id}`                      | Get a specific monthly payroll                |
| PUT    | `/api/monthly-payrolls/{id}`                      | Update a monthly payroll                      |
| DELETE | `/api/monthly-payrolls/{id}`                      | Delete a monthly payroll                      |
| GET    | `/api/monthly-payrolls/month-year/{month}/{year}` | Get payrolls for a specific month and year    |
| GET    | `/api/monthly-payrolls/user/{userId}`             | Get payrolls for a user                       |
| GET    | `/api/monthly-payrolls/status/{status}`           | Get payrolls by status                        |
| GET    | `/api/monthly-payrolls/department/{departmentId}` | Get payrolls for a department                 |
| POST   | `/api/monthly-payrolls/date-range`                | Get payrolls in a date range                  |
| GET    | `/api/monthly-payrolls/total/{month}/{year}`      | Get total payroll amount for a month and year |
| POST   | `/api/monthly-payrolls/{id}/approve`              | Approve a payroll                             |
| POST   | `/api/monthly-payrolls/{id}/mark-paid`            | Mark a payroll as paid                        |
| POST   | `/api/monthly-payrolls/{id}/cancel`               | Cancel a payroll                              |

## Attendances

| Method | Endpoint                         | Description                            |
| ------ | -------------------------------- | -------------------------------------- |
| GET    | `/api/attendances`               | List all attendance records            |
| POST   | `/api/attendances`               | Create a new attendance record         |
| GET    | `/api/attendances/{id}`          | Get a specific attendance record       |
| PUT    | `/api/attendances/{id}`          | Update an attendance record            |
| DELETE | `/api/attendances/{id}`          | Delete an attendance record            |
| GET    | `/api/attendances/user/{userId}` | Get attendance records for a user      |
| POST   | `/api/attendances/date-range`    | Get attendance records in a date range |

## Base Salaries

| Method | Endpoint                           | Description                  |
| ------ | ---------------------------------- | ---------------------------- |
| GET    | `/api/base-salaries`               | List all base salaries       |
| POST   | `/api/base-salaries`               | Create a new base salary     |
| GET    | `/api/base-salaries/{id}`          | Get a specific base salary   |
| PUT    | `/api/base-salaries/{id}`          | Update a base salary         |
| DELETE | `/api/base-salaries/{id}`          | Delete a base salary         |
| GET    | `/api/base-salaries/user/{userId}` | Get base salaries for a user |

## Benefit Plans

| Method | Endpoint                           | Description                  |
| ------ | ---------------------------------- | ---------------------------- |
| GET    | `/api/benefit-plans`               | List all benefit plans       |
| POST   | `/api/benefit-plans`               | Create a new benefit plan    |
| GET    | `/api/benefit-plans/{id}`          | Get a specific benefit plan  |
| PUT    | `/api/benefit-plans/{id}`          | Update a benefit plan        |
| DELETE | `/api/benefit-plans/{id}`          | Delete a benefit plan        |
| GET    | `/api/benefit-plans/user/{userId}` | Get benefit plans for a user |
| GET    | `/api/benefit-plans/active`        | Get active benefit plans     |

## Candidates

| Method | Endpoint                              | Description                   |
| ------ | ------------------------------------- | ----------------------------- |
| GET    | `/api/candidates`                     | List all candidates           |
| POST   | `/api/candidates`                     | Create a new candidate        |
| GET    | `/api/candidates/{id}`                | Get a specific candidate      |
| PUT    | `/api/candidates/{id}`                | Update a candidate            |
| DELETE | `/api/candidates/{id}`                | Delete a candidate            |
| GET    | `/api/candidates/position/{position}` | Get candidates for a position |
| GET    | `/api/candidates/status/{status}`     | Get candidates by status      |
| POST   | `/api/candidates/search`              | Search candidates             |

## Compliance

| Method | Endpoint                          | Description                       |
| ------ | --------------------------------- | --------------------------------- |
| GET    | `/api/compliance`                 | List all compliance records       |
| POST   | `/api/compliance`                 | Create a new compliance record    |
| GET    | `/api/compliance/{id}`            | Get a specific compliance record  |
| PUT    | `/api/compliance/{id}`            | Update a compliance record        |
| DELETE | `/api/compliance/{id}`            | Delete a compliance record        |
| GET    | `/api/compliance/user/{userId}`   | Get compliance records for a user |
| GET    | `/api/compliance/status/{status}` | Get compliance records by status  |
| GET    | `/api/compliance/type/{type}`     | Get compliance records by type    |
| GET    | `/api/compliance/expiring`        | Get expiring compliance records   |

## Documents

| Method | Endpoint                             | Description               |
| ------ | ------------------------------------ | ------------------------- |
| GET    | `/api/documents`                     | List all documents        |
| POST   | `/api/documents`                     | Upload a new document     |
| GET    | `/api/documents/{id}`                | Get a specific document   |
| PUT    | `/api/documents/{id}`                | Update a document         |
| DELETE | `/api/documents/{id}`                | Delete a document         |
| GET    | `/api/documents/user/{userId}`       | Get documents for a user  |
| GET    | `/api/documents/category/{category}` | Get documents by category |
| GET    | `/api/documents/type/{documentType}` | Get documents by type     |
| POST   | `/api/documents/search`              | Search documents          |

## Roles

| Method | Endpoint                | Description          |
| ------ | ----------------------- | -------------------- |
| GET    | `/api/roles`            | List all roles       |
| POST   | `/api/roles`            | Create a new role    |
| GET    | `/api/roles/{id}`       | Get a specific role  |
| PUT    | `/api/roles/{id}`       | Update a role        |
| DELETE | `/api/roles/{id}`       | Delete a role        |
| GET    | `/api/roles/{id}/tasks` | Get tasks for a role |

## Onboarding Tasks

| Method | Endpoint                                           | Description                          |
| ------ | -------------------------------------------------- | ------------------------------------ |
| GET    | `/api/onboarding-tasks`                            | List all onboarding tasks            |
| POST   | `/api/onboarding-tasks`                            | Create a new onboarding task         |
| GET    | `/api/onboarding-tasks/{id}`                       | Get a specific onboarding task       |
| PUT    | `/api/onboarding-tasks/{id}`                       | Update an onboarding task            |
| DELETE | `/api/onboarding-tasks/{id}`                       | Delete an onboarding task            |
| GET    | `/api/onboarding-tasks/employee/{employeeId}`      | Get onboarding tasks for an employee |
| GET    | `/api/onboarding-tasks/role/{roleId}`              | Get onboarding tasks for a role      |
| GET    | `/api/onboarding-tasks/roles`                      | List all roles for onboarding        |
| GET    | `/api/onboarding-tasks/roles/{id}`                 | Get a specific role for onboarding   |
| POST   | `/api/onboarding-tasks/roles`                      | Create a new role for onboarding     |
| PUT    | `/api/onboarding-tasks/roles/{id}`                 | Update a role for onboarding         |
| DELETE | `/api/onboarding-tasks/roles/{id}`                 | Delete a role for onboarding         |
| GET    | `/api/onboarding-tasks/roles/{roleId}/tasks`       | Get tasks for a specific role        |
| POST   | `/api/onboarding-tasks/roles/assign-task`          | Assign a task to a role              |
| POST   | `/api/onboarding-tasks/roles/remove-task`          | Remove a task from a role            |
| POST   | `/api/onboarding-tasks/employee/assign-role-tasks` | Assign role tasks to an employee     |

## Authorization

The API has three main user types with different access levels:

1. **Guest** (user type 0): Can only view jobs and limited information.
2. **Employee** (user type 1): Can access their own tasks, applications, documents, and benefit information.
3. **HR** (user type 2): Has full access to manage all aspects of the HR system including insurance plans, benefits, roles, and onboarding tasks.

Some routes are available to all authenticated users, while others are restricted by user type.
