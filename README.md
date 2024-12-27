
### Create user 
```text
http://127.0.0.1:8000/api/signup
```
 ```json
{
  "first_name": "md",
  "last_name": "kabbya",
  "email": "kabbya7@gmail.com",
  "phone": "+8801721597157",
  "gender": "male",
  "password": "Str0ng@Pass12",
  "password_confirmation": "Str0ng@Pass12"
}
```text 
Post Method
Endpoint:/api/tasks/
```

```json
{
    "title": "Task Title",
    "description": "Et itaque voluptatem sunt quia ducimus. Asperiores alias labore inventore quibusdam tempora. Praesentium officiis maxime id accusantium cumque ut enim.",
    "due_date": "2024-12-27",
    "priority": "high",
    "status": "pending",
    "assigned_to":1,
    "user_id": 1
}
```

### Create Notification
create a notification system for success or error messages when performing actions like record deletion, creation Etc and on delete the restore system.
