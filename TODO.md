# TODO

...list of what will be developed

## In development
- [ ] Config
  - [ ] webhook
- [ ] Migrations
    - [ ] max_send_schedule
- [ ] Models
    - [ ] MaxSendSchedule
- [ ] Enums
    - [ ] Action
    - [ ] ChatAdminPermission
    - [ ] MarkupType
    - [ ] MessageLinkType
    - [ ] ReplyButtonType
- [ ] Objects
    - [ ] Chat
    - [ ] ChatMember
    - [ ] Update
        - [ ] Chat
        - [ ] UserToChat
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
- [ ] Route mini app
- [ ] Route mini app for menu
- [ ] Route mini app menu action
- [ ] Route Webhook with settings path, update_types and secret
- [ ] UnitTest
- [ ] Service handle update
- [ ] Queue
- [ ] Commands
    - [ ] max:update
    - [ ] max:handle
    - [ ] max:send:schedule
- [ ] Supervisor

## Documentation

- [ ] I have to get started...

Support MAX
- Long Polling (GET /updates) не планируется как основной способ работы и не является заменой webhook.
- Он оставляется только для разработки и тестирования, а для production используется webhook через /subscriptions.
