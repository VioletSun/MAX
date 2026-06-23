# TODO

...list of what will be developed

## In development
- [ ] Config
  - [ ] webhook
- [ ] Migrations
    - [ ] max_send
    - [ ] max_schedule
- [ ] Models
    - [ ] MaxSend
    - [ ] MaxSchedule
- [ ] Enums
    - [ ] Action
    - [ ] ChatAdminPermission
    - [ ] InlineButtonType
    - [ ] Intent
    - [ ] MarkupType
    - [ ] MessageFormat
    - [ ] MessageLinkType
    - [ ] ReplyButtonType
    - [ ] SenderAction
- [ ] Objects
    - [ ] Chat
    - [ ] ChatMember
    - [ ] Update
        - [ ] message
          - [ ] link
          - [ ] stat
          - [ ] url
- [ ] Methods
    - [ ] Max::update()
        - [ ] save_data
          - [ ] MaxChat
          - [ ] max_chat_users
        - [ ] link
        - [ ] enqueue
    - [ ] Max::upload()
    - [ ] Max::videoInfo()
    - [ ] Max::messageInfo()
    - [ ] Webhook
        - [ ] Max::subscriptions()
        - [ ] Max::subscriptionSet()
        - [ ] Max::subscriptionDelete()
    - [ ] Chats
        - [ ] Max::chatInfo(chatLink|chatId)
        - [ ] Max::chatEdit()
        - [ ] Max::chatAction()
        - [ ] Max::chatPins()
        - [ ] Max::chatPin()
        - [ ] Max::chatPinDelete()
        - [ ] Max::chatMeInfo()
        - [ ] Max::chatMeDelete()
        - [ ] Max::chatAdmins()
        - [ ] Max::chatSetAdmin()
        - [ ] Max::chatRevokeAdmin()
        - [ ] Max::chatMembers()
        - [ ] Max::chatBulkMembers()
        - [ ] Max::chatDeleteMember()
        - [ ] Max::chat()
        - [ ] Max::chat()
- [ ] Route Webhook with settings path, update_types and secret
- [ ] UnitTest
- [ ] Service handle update
- [ ] Queue
- [ ] Commands
    - [ ] max:update
    - [ ] max:handle
    - [ ] max:send
    - [ ] max:schedule
- [ ] Supervisor

## Documentation

- [ ] I have to get started...

