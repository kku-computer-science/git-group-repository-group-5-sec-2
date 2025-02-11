*** Settings ***
Library    SeleniumLibrary
Resource          resource.robot

*** Test Cases ***
Test Invalid Next Button Click
    Open Web Page
    Click Invalid Next Button
    Close Browser

Test Invalid Prev Button Click
    Click Invalid Prev Button
    Close Browser
    Go Back

Test Invalid Highlight Paper Image Click
    Open Web Page
    Click Invalid Highlight Paper Image
    Close Browser

Test Invalid Teacher Title Click
    Open Web Page
    Click Invalid Teacher Title
    Close Browser