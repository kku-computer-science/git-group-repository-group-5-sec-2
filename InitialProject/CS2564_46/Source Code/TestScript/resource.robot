*** Settings ***
Library    SeleniumLibrary

*** Variables ***
${BROWSER}    Chrome
${URL}    http://127.0.0.1:8000/  # เปลี่ยนเป็น URL ของเว็บจริง
${CAROUSEL_INNER}    xpath=//div[@class='carousel-inner']
${CAROUSEL_ITEM}    xpath=//div[contains(@class, 'carousel-item')]
${ACTIVE_CAROUSEL}    xpath=//div[contains(@class, 'carousel-item active')]
${NEXT_BUTTON}    xpath=//button[@class='carousel-control-next']
${PREV_BUTTON}    xpath=//button[@class='carousel-control-prev']
${IMAGE}    //img[contains(@class, 'hl-image')]
${TITLE}    //a[contains(@class, 'author-name')]


*** Keywords ***
Open Web Page
    Open Browser    ${URL}    ${BROWSER}
    Maximize Browser Window
    Wait Until Page Contains Element    ${IMAGE}    timeout=5s

Click Highlight Paper Image
    ${image}    Get WebElement    ${IMAGE}
    Click Element    ${image}
    Sleep    8s    # รอให้หน้าโหลด
    SeleniumLibrary.Location Should Be    ${URL}    # ตรวจสอบว่าหน้าเปลี่ยน
    Go Back


Click Teacher Title
    ${teacher_link}    Get WebElement    ${TITLE}
    Click Element    ${teacher_link}
    Sleep    6s    # รอให้หน้าโหลด
    SeleniumLibrary.Location Should Be    ${URL}    # ตรวจสอบว่าหน้าเปลี่ยน
    Go Back
    

Verify Carousel Items Exist
    ${items}=    Get WebElements    ${CAROUSEL_ITEM}
    Should Not Be Empty    ${items}    Carousel should have items

Verify Only One Active Item
    ${active}=    Get WebElements    ${ACTIVE_CAROUSEL}
    Should Be Equal As Integers    ${active.__len__()}    1    There should be exactly one active carousel item

Navigate To Next Slide
    Click Button    ${NEXT_BUTTON}
    Sleep    2s
    ${new_active}=    Get WebElements    ${ACTIVE_CAROUSEL}
    Should Be Equal As Integers    ${new_active.__len__()}    1    Next slide should be active

Navigate To Previous Slide
    Click Button    ${PREV_BUTTON}
    Sleep    2s
    ${new_active}=    Get WebElements    ${ACTIVE_CAROUSEL}
    Should Be Equal As Integers    ${new_active.__len__()}    1    Previous slide should be active

Verify Carousel Is Not Empty
    ${items}=    Get WebElements    ${CAROUSEL_ITEM}
    Should Not Be Empty    ${items}    Error: Carousel has no items!

Verify No Multiple Active Items
    ${active_items}=    Get WebElements    ${ACTIVE_CAROUSEL}
    Should Be Equal As Integers    ${active_items.__len__()}    1    Error: Multiple active carousel items detected!

Verify Navigation Buttons Are Disabled If Single Item
    ${items}=    Get WebElements    ${CAROUSEL_ITEM}
    ${count}=    Evaluate    len(${items})
    Run Keyword If    ${count} == 1    Element Should Be Disabled    ${NEXT_BUTTON}
    Run Keyword If    ${count} == 1    Element Should Be Disabled    ${PREV_BUTTON}

Verify Navigation Works Properly
    ${current_active}=    Get WebElement    ${ACTIVE_CAROUSEL}
    Click Button    ${NEXT_BUTTON}
    Sleep    2s
    ${new_active}=    Get WebElement    ${ACTIVE_CAROUSEL}
    Should Not Be Equal    ${current_active}    ${new_active}    Error: Next button did not change the slide!

    Click Button    ${PREV_BUTTON}
    Sleep    2s
    ${previous_active}=    Get WebElement    ${ACTIVE_CAROUSEL}
    Should Not Be Equal    ${new_active}    ${previous_active}    Error: Previous button did not change the slide!
