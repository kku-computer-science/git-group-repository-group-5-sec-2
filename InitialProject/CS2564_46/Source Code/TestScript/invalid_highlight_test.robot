*** Settings ***
Library    SeleniumLibrary
Resource          resource.robot

*** Keywords ***
Verify Location Changes After Clicking
    ${initial_url}=    Get Location
    Sleep    2s
    ${new_url}=    Get Location
    Should Not Be Equal    ${initial_url}    ${new_url}    URL should change after clicking

Verify Carousel DoesNot Move
    ${current_active}=    Get WebElement    //div[contains(@class, 'carousel-item active')]
    Click Button    ${NEXT_BUTTON}
    Sleep    2s
    ${new_active}=    Get WebElement    //div[contains(@class, 'carousel-item active')]
    Should Be Equal As Integers    ${current_active.__len__()}    ${new_active.__len__()}    Carousel should not move

*** Test Cases ***
Test Invalid Clicking Highlight Paper Image
    Open Web Page
    Click Element    ${IMAGE}
    Verify Location Changes After Clicking
    Close Browser

Test Invalid Clicking Author Name
    Open Web Page
    Click Element    ${TITLE}
    Verify Location Changes After Clicking
    Close Browser

Test Carousel Does Not Move With Only One Item
    Open Web Page
    Wait Until Element Is Visible    ${CAROUSEL_ITEM}    5s
    Verify Carousel DoesNot Move
    Close Browser