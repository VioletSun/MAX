# Changelog

All notable changes to `MAX` will be documented in this file.

## Version 1.0.1.6 - 2026-06-23
Methods:
- MAX::me()
- MAX::updates()
- - with save to database
- Max::builder()
- - ->chatId()
- - ->messageId()
- - ->text()
- - ->disableLinkPreview()
- - ->attachments()
- - - ->image()
- - - ->video()
- - - ->audio()
- - - ->file()
- - - ->sticker()
- - - ->contact()
- - - ->location()
- - - ->share()
- - - ->inlineKeyboard()
- - - - ->row()
- - - - ->callback()
- - - - ->link()
- - - - ->requestGeoLocation()
- - - - ->requestContact()
- - - - ->openApp()
- - - - ->message()
- - - - ->clipboard()
- - ->send()
- - ->edit()
- - ->delete()
- - ->dump()
- MAX::sendMessage()
- MAX::editMessage()
- MAX::deleteMessage()

Model & migrations
- MaxUpdate
- MaxUser

## Version 1.0.0.15 - 2026-06-15

### Created
- Client
- Api
- Models and migrations: MaxUpdate, MaxUser

### Added
- Methods "me" & "send"

## Version 1.0.0.1

### Added
- Start project
