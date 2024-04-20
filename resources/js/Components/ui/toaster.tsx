"use client"

import {
  Toast,
  ToastClose,
  ToastDescription,
  ToastProvider,
  ToastTitle,
  ToastViewport,
} from "@/Components/ui/toast"
import { useToast } from "@/Components/ui/use-toast"
import { CheckCircleIcon, FileWarning } from "lucide-react"

export function Toaster() {
  const { toasts } = useToast()

  return (
    <ToastProvider>
      {toasts.map(function ({ id, title, description, action, variant, ...props }) {
        return (
          <Toast key={id} {...props}>
            <div className="grid gap-1">
              {title && <ToastTitle
                className={variant === "success" ? "text-green-600" : "text-red-500"}
              >{title}</ToastTitle>}
              {description && (
                <ToastDescription>{description}</ToastDescription>
              )}
            </div>
            {action}
            <ToastClose />
            {
              variant === "success" ? (
                <CheckCircleIcon
                  className="text-green-600"
                  size={24} />
              ) : <FileWarning
                className="text-red-500"
                size={24} />
            }
          </Toast>
        )
      })}
      <ToastViewport />
    </ToastProvider>
  )
}
