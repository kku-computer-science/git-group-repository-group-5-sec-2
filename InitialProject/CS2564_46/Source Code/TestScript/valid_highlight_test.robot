*** Settings ***
Library    SeleniumLibrary
Resource          resorce.robot

*** Test Cases ***
Test Clicking Highlight Paper Image
    Open Web Page
    Click Highlight Paper Image
    
Test Clicking Highlight Teacher Title
    Open Web Page
    Click Teacher Title
    
    Close Browser

Test Carousel Navigation
    Open Web Page
    Wait Until Element Is Visible    ${CAROUSEL_INNER}    5s
    Verify Carousel Items Exist
    Verify Only One Active Item
    Navigate To Next Slide
    Navigate To Previous Slide
    Close Browser